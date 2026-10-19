<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';
require_once __DIR__ . '/functions/products.php';
require_once __DIR__ . '/functions/categories.php';

$cat_slug = $_GET['cat'] ?? 'all';
$search_query = trim($_GET['q'] ?? '');
$collection_slug = $_GET['collection'] ?? '';

$categories = get_active_categories();
$current_category = null;

if ($cat_slug !== 'all') {
    foreach ($categories as $c) {
        if ($c['slug'] === $cat_slug) {
            $current_category = $c;
            break;
        }
    }
}

$page_title = $current_category ? $current_category['name'] . ' Furniture' : 'All Furniture Collections';

// Query products
$products = [];
if ($pdo) {
    try {
        $sql = "SELECT p.*, pi.image as primary_image, c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE p.status = 'active'";
        $params = [];

        if ($current_category) {
            $sql .= " AND p.category_id = ?";
            $params[] = $current_category['id'];
        }

        if (!empty($search_query)) {
            $sql .= " AND (p.name LIKE ? OR p.product_code LIKE ? OR p.description LIKE ?)";
            $params[] = "%$search_query%";
            $params[] = "%$search_query%";
            $params[] = "%$search_query%";
        }

        $sql .= " ORDER BY p.sort_order ASC, p.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();
    } catch (Exception $e) {}
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div style="background: var(--color-background-soft); padding: 48px 0; border-bottom: 1px solid var(--color-border);">
    <div class="vh-container">
        <div style="font-size: 13px; color: var(--color-text-muted); margin-bottom: 8px;">
            <a href="index.php">Home</a> &rsaquo; <span><?= htmlspecialchars($page_title) ?></span>
        </div>
        <h1 style="font-size: 38px; margin-bottom: 8px;"><?= htmlspecialchars($page_title) ?></h1>
        <p style="color: var(--color-text-secondary); margin: 0; max-width: 600px;">
            <?= htmlspecialchars($current_category['description'] ?? 'Explore our complete architectural and residential furniture catalogue.') ?>
        </p>
    </div>
</div>

<div class="vh-container" style="padding-top: 48px; padding-bottom: 80px;">
    <!-- Category Filter Bar -->
    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid var(--color-border);">
        <a href="category.php?cat=all" class="vh-btn <?= $cat_slug === 'all' ? 'vh-btn-primary' : 'vh-btn-outline' ?> vh-btn-sm">
            All Products
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="category.php?cat=<?= urlencode($cat['slug']) ?>" class="vh-btn <?= $cat_slug === $cat['slug'] ? 'vh-btn-primary' : 'vh-btn-outline' ?> vh-btn-sm">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($products)): ?>
        <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-card); border: 1px solid var(--color-border);">
            <i class="bi bi-box-seam" style="font-size: 48px; color: var(--color-gold);"></i>
            <h3 style="margin-top: 16px;">No products found</h3>
            <p style="color: var(--color-text-muted);">Try adjusting your search criteria or explore other categories.</p>
            <a href="category.php?cat=all" class="vh-btn vh-btn-gold vh-btn-sm" style="margin-top: 12px;">Browse All Collections</a>
        </div>
    <?php else: ?>
        <div class="vh-product-grid">
            <?php foreach ($products as $prod): 
                $img = !empty($prod['primary_image']) ? $prod['primary_image'] : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80';
            ?>
            <div class="vh-product-card">
                <div class="vh-product-img-box">
                    <a href="product.php?slug=<?= urlencode($prod['slug']) ?>">
                        <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="vh-product-img" loading="lazy">
                    </a>
                </div>
                <div class="vh-product-body">
                    <div class="vh-product-code"><?= htmlspecialchars($prod['product_code']) ?> &bull; <?= htmlspecialchars($prod['category_name'] ?? 'Collection') ?></div>
                    <h3 class="vh-product-title">
                        <a href="product.php?slug=<?= urlencode($prod['slug']) ?>"><?= htmlspecialchars($prod['name']) ?></a>
                    </h3>
                    <p class="vh-product-desc"><?= htmlspecialchars($prod['short_desc'] ?? '') ?></p>
                    <div class="vh-product-meta">
                        <button type="button" class="vh-btn vh-btn-outline vh-btn-sm" onclick="addToCart(<?= (int)$prod['id'] ?>, '<?= addslashes($prod['name']) ?>', '<?= addslashes($prod['product_code']) ?>', '<?= addslashes($img) ?>')">
                            <i class="bi bi-bag-plus"></i>
                            <span>Add</span>
                        </button>
                        <button type="button" class="vh-btn vh-btn-gold vh-btn-sm" onclick="openQuoteModal('<?= addslashes($prod['name']) ?>', '<?= addslashes($prod['product_code']) ?>', <?= (int)$prod['id'] ?>)">
                            <span>Quote</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
