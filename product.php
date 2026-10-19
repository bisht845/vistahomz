<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';
require_once __DIR__ . '/functions/products.php';
require_once __DIR__ . '/functions/categories.php';

$slug = $_GET['slug'] ?? '';
$product = get_product_by_slug($slug);

if (!$product) {
    header('Location: category.php');
    exit;
}

$page_title = $product['name'] . ' (' . $product['product_code'] . ')';
$page_desc = $product['short_desc'] ?? 'Luxury furniture by VISTAHOMZ';

// Fetch product gallery images
$gallery = [];
$features = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, sort_order ASC");
        $stmt->execute([$product['id']]);
        $gallery = $stmt->fetchAll();

        $stmt2 = $pdo->prepare("SELECT * FROM product_features WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt2->execute([$product['id']]);
        $features = $stmt2->fetchAll();
    } catch (Exception $e) {}
}

$main_img = !empty($gallery) ? $gallery[0]['image'] : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div style="background: var(--color-background-soft); padding: 32px 0; border-bottom: 1px solid var(--color-border);">
    <div class="vh-container">
        <div style="font-size: 13px; color: var(--color-text-muted);">
            <a href="index.php">Home</a> &rsaquo;
            <a href="category.php?cat=<?= urlencode($product['category_name'] ?? 'all') ?>"><?= htmlspecialchars($product['category_name'] ?? 'Catalog') ?></a> &rsaquo;
            <span><?= htmlspecialchars($product['name']) ?></span>
        </div>
    </div>
</div>

<div class="vh-container" style="padding-top: 56px; padding-bottom: 90px;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 48px;" class="product-detail-grid">
        <!-- Image Showcase -->
        <div>
            <div style="border-radius: var(--radius-large); overflow: hidden; background: #fff; border: 1px solid var(--color-border); box-shadow: var(--shadow-soft); margin-bottom: 16px;">
                <img id="mainProductImg" src="<?= htmlspecialchars($main_img) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 500px; object-fit: cover;">
            </div>
            <?php if (count($gallery) > 1): ?>
            <div style="display: flex; gap: 12px; overflow-x: auto;">
                <?php foreach ($gallery as $g): ?>
                <img src="<?= htmlspecialchars($g['image']) ?>" alt="Thumbnail" onclick="document.getElementById('mainProductImg').src = this.src;" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid var(--color-border);" class="vh-thumb">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Specifications & Quote Actions -->
        <div>
            <span class="vh-product-code" style="font-size: 13px;"><?= htmlspecialchars($product['product_code']) ?></span>
            <h1 style="font-size: 36px; margin: 8px 0 16px;"><?= htmlspecialchars($product['name']) ?></h1>
            <p style="font-size: 16px; color: var(--color-text-secondary); line-height: 1.7; margin-bottom: 24px;">
                <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
            </p>

            <!-- Specs Table -->
            <div style="background: var(--color-background-soft); border-radius: var(--radius-card); padding: 24px; margin-bottom: 32px; border: 1px solid var(--color-border);">
                <h4 style="font-size: 16px; margin-bottom: 16px; font-family: var(--font-body);">Materials & Specifications</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 14px;">
                    <div><strong>Material:</strong> <?= htmlspecialchars($product['material'] ?? 'Solid Hardwood & Premium Fabric') ?></div>
                    <div><strong>Availability:</strong> <span style="color: #2e7d32; font-weight: 600;">In Production / Custom Build</span></div>
                    <div><strong>Warranty:</strong> 5 Years Structural Warranty</div>
                    <div><strong>Custom Finishes:</strong> Available on request</div>
                </div>
            </div>

            <?php if (!empty($features)): ?>
            <div style="margin-bottom: 32px;">
                <h4 style="font-size: 16px; margin-bottom: 12px; font-family: var(--font-body);">Key Features</h4>
                <ul style="padding-left: 20px; color: var(--color-text-secondary); font-size: 14px; line-height: 1.8;">
                    <?php foreach ($features as $f): ?>
                    <li><?= htmlspecialchars($f['feature']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                <button type="button" class="vh-btn vh-btn-gold vh-btn-lg" onclick="openQuoteModal('<?= addslashes($product['name']) ?>', '<?= addslashes($product['product_code']) ?>', <?= (int)$product['id'] ?>)">
                    <i class="bi bi-chat-quote-fill"></i>
                    <span>Request Custom Quote</span>
                </button>
                <button type="button" class="vh-btn vh-btn-outline vh-btn-lg" onclick="addToCart(<?= (int)$product['id'] ?>, '<?= addslashes($product['name']) ?>', '<?= addslashes($product['product_code']) ?>', '<?= addslashes($main_img) ?>')">
                    <i class="bi bi-bag-plus"></i>
                    <span>Add to Inquiry Cart</span>
                </button>
                <a href="https://wa.me/917042704454?text=<?= urlencode('Hello VISTAHOMZ, I am inquiring about product ' . $product['name'] . ' (' . $product['product_code'] . ')') ?>" target="_blank" class="vh-btn vh-btn-outline vh-btn-lg" style="color: #25D366; border-color: #25D366;">
                    <i class="bi bi-whatsapp"></i>
                    <span>WhatsApp Inquiry</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media (min-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1.1fr 0.9fr !important;
    }
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
