<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';
require_once __DIR__ . '/functions/products.php';
require_once __DIR__ . '/functions/categories.php'; 

$page_title = 'VISTAHOMZ | Luxury Furniture';
$page_desc = 'Discover master-crafted furniture for residences, offices, hotels, and luxury commercial spaces by VISTAHOMZ.';

// Dynamic data queries preserving existing schema
$banner = null;
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM homepage_banners WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 1");
        $banner = $stmt->fetch();
    } catch (Exception $e) {}
}

$categories = get_active_categories();
$featured_products = get_featured_products(8);
$collections = get_collections();

$industries = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM industries WHERE is_active = 1 ORDER BY sort_order ASC");
        $industries = $stmt->fetchAll();
    } catch (Exception $e) {}
}

$testimonials = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 4");
        $testimonials = $stmt->fetchAll();
    } catch (Exception $e) {}
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- 1. Hero Section -->
<section class="vh-hero">
    <div class="vh-container">
        <div class="vh-hero-grid">
            <div class="vh-hero-content">
                <span class="vh-hero-eyebrow">
                    <?= htmlspecialchars($banner['label'] ?? 'Crafted For Exceptional Spaces') ?>
                </span>
                <h1 class="vh-hero-title">
                    <?= !empty($banner['title']) ? htmlspecialchars($banner['title']) : 'Furniture That Defines <span class="gold">Your Space.</span>' ?>
                </h1>
                <p class="vh-hero-subtitle">
                    <?= !empty($banner['subtitle']) ? htmlspecialchars($banner['subtitle']) : 'Discover thoughtfully designed bespoke furniture for residences, high-performance office environments, and hospitality destinations.' ?>
                </p>
                <div class="vh-hero-cta">
                    <a href="<?= !empty($banner['btn1_url']) ? htmlspecialchars($banner['btn1_url']) : 'category.php?cat=all' ?>" class="vh-btn vh-btn-gold vh-btn-lg">
                        <span><?= !empty($banner['btn1_text']) ? htmlspecialchars($banner['btn1_text']) : 'Explore Collections' ?></span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <button type="button" class="vh-btn vh-btn-outline vh-btn-lg" onclick="openQuoteModal()">
                        <i class="bi bi-chat-quote-fill"></i>
                        <span><?= !empty($banner['btn2_text']) ? htmlspecialchars($banner['btn2_text']) : 'Get Free Quote' ?></span>
                    </button>
                </div>
            </div>
            <div class="vh-hero-image-wrapper">
                <img src="<?= !empty($banner['image']) ? htmlspecialchars($banner['image']) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=1200&q=80' ?>" alt="VISTAHOMZ Luxury Living" class="vh-hero-img">
                <div class="vh-hero-floating-card d-none d-sm-flex">
                    <div class="vh-trust-icon" style="width: 40px; height: 40px; font-size: 18px;">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Architectural Grade</div>
                        <div style="font-size: 12px; color: var(--color-text-muted);">Kiln-dried hardwoods & precision steel</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Trust & Service Highlights -->
<section class="vh-trust-section">
    <div class="vh-container">
        <div class="vh-trust-grid">
            <div class="vh-trust-item">
                <div class="vh-trust-icon"><i class="bi bi-gem"></i></div>
                <div>
                    <h4 class="vh-trust-title">Master Quality</h4>
                    <p class="vh-trust-desc">Solid wood framing, premium fabrics & rigorous quality assurance.</p>
                </div>
            </div>
            <div class="vh-trust-item">
                <div class="vh-trust-icon"><i class="bi bi-buildings"></i></div>
                <div>
                    <h4 class="vh-trust-title">Commercial & Home</h4>
                    <p class="vh-trust-desc">Tailored solutions for residences, corporate offices, hotels & cafes.</p>
                </div>
            </div>
            <div class="vh-trust-item">
                <div class="vh-trust-icon"><i class="bi bi-truck"></i></div>
                <div>
                    <h4 class="vh-trust-title">Pan-India Delivery</h4>
                    <p class="vh-trust-desc">Careful white-glove shipping & professional on-site installation.</p>
                </div>
            </div>
            <div class="vh-trust-item">
                <div class="vh-trust-icon"><i class="bi bi-layers-half"></i></div>
                <div>
                    <h4 class="vh-trust-title">Custom & Bulk Orders</h4>
                    <p class="vh-trust-desc">Bespoke dimensions, finishes, and turnkey commercial volume pricing.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Product Categories Section -->
<section class="vh-section">
    <div class="vh-container">
        <div class="vh-section-header">
            <span class="vh-section-eyebrow">Curated Environments</span>
            <h2 class="vh-section-title">Explore by Category</h2>
            <p class="vh-section-desc">
                From intimate living quarters to executive boardrooms, explore meticulously engineered furniture systems.
            </p>
        </div>

        <div class="vh-category-grid">
            <?php
            $cat_defaults = [
                'living' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80',
                'dining' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=500&q=80',
                'bedroom' => 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=500&q=80',
                'office' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500&q=80',
                'commercial' => 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=500&q=80',
                'decor' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&q=80',
            ];
            foreach ($categories as $cat):
                $img = $cat['image'] ?? ($cat_defaults[$cat['slug']] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80');
            ?>
            <a href="category.php?cat=<?= urlencode($cat['slug']) ?>" class="vh-category-card">
                <div class="vh-category-img-box">
                    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($cat['name']) ?>" class="vh-category-img" loading="lazy">
                </div>
                <div class="vh-category-content">
                    <h3 class="vh-category-name"><?= htmlspecialchars($cat['name']) ?></h3>
                    <span class="vh-category-count">Explore &rarr;</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 4. Featured & Bestselling Products Section -->
<section class="vh-section" style="background-color: var(--color-background-soft);">
    <div class="vh-container">
        <div class="vh-section-header">
            <span class="vh-section-eyebrow">Signature Creations</span>
            <h2 class="vh-section-title">Featured Collections</h2>
            <p class="vh-section-desc">
                Exemplary craftsmanship, timeless silhouettes, and uncompromising structural durability.
            </p>
        </div>

        <div class="vh-product-grid">
            <?php foreach ($featured_products as $prod): 
                $img = !empty($prod['primary_image']) ? $prod['primary_image'] : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80';
            ?>
            <div class="vh-product-card">
                <div class="vh-product-img-box">
                    <div class="vh-product-badges">
                        <?php if (!empty($prod['is_bestseller'])): ?>
                            <span class="vh-badge vh-badge-gold">Bestseller</span>
                        <?php endif; ?>
                        <?php if (!empty($prod['is_new'])): ?>
                            <span class="vh-badge vh-badge-dark">New Arrival</span>
                        <?php endif; ?>
                    </div>
                    <a href="product.php?slug=<?= urlencode($prod['slug']) ?>">
                        <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="vh-product-img" loading="lazy">
                    </a>
                </div>
                <div class="vh-product-body">
                    <div class="vh-product-code"><?= htmlspecialchars($prod['product_code']) ?> &bull; <?= htmlspecialchars($prod['category_name'] ?? 'Collection') ?></div>
                    <h3 class="vh-product-title">
                        <a href="product.php?slug=<?= urlencode($prod['slug']) ?>"><?= htmlspecialchars($prod['name']) ?></a>
                    </h3>
                    <p class="vh-product-desc">
                        <?= htmlspecialchars($prod['short_desc'] ?? substr($prod['description'] ?? '', 0, 90) . '...') ?>
                    </p>
                    <div class="vh-product-meta">
                        <button type="button" class="vh-btn vh-btn-outline vh-btn-sm" onclick="addToCart(<?= (int)$prod['id'] ?>, '<?= addslashes($prod['name']) ?>', '<?= addslashes($prod['product_code']) ?>', '<?= addslashes($img) ?>')">
                            <i class="bi bi-bag-plus"></i>
                            <span>Add to Cart</span>
                        </button>
                        <button type="button" class="vh-btn vh-btn-gold vh-btn-sm" onclick="openQuoteModal('<?= addslashes($prod['name']) ?>', '<?= addslashes($prod['product_code']) ?>', <?= (int)$prod['id'] ?>)">
                            <span>Quote</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 48px;">
            <a href="category.php?cat=all" class="vh-btn vh-btn-primary vh-btn-lg">
                <span>View Complete Catalogue</span>
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </a>
        </div>
    </div>
</section>

<!-- 5. Collections Editorial Showcase -->
<?php if (!empty($collections)): ?>
<section class="vh-section">
    <div class="vh-container">
        <div class="vh-section-header">
            <span class="vh-section-eyebrow">Aesthetic Series</span>
            <h2 class="vh-section-title">Design Collections</h2>
            <p class="vh-section-desc">Harmonized finishes and tailored suites engineered for cohesive interiors.</p>
        </div>

        <div class="vh-collections-grid">
            <?php
            $col_imgs = [
                'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=600&q=80',
                'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=600&q=80',
                'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
                'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?w=600&q=80'
            ];
            $idx = 0;
            foreach ($collections as $col):
                $cimg = $col['image'] ?? ($col_imgs[$idx % 4]);
                $idx++;
            ?>
            <a href="category.php?collection=<?= urlencode($col['slug']) ?>" class="vh-collection-card">
                <img src="<?= htmlspecialchars($cimg) ?>" alt="<?= htmlspecialchars($col['name']) ?>" class="vh-collection-img" loading="lazy">
                <div class="vh-collection-overlay">
                    <h3 class="vh-collection-title"><?= htmlspecialchars($col['name']) ?></h3>
                    <p class="vh-collection-desc"><?= htmlspecialchars($col['description'] ?? 'Curated luxury designs') ?></p>
                    <span class="vh-collection-link">Explore Series &rarr;</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 6. Commercial & Residential Solutions -->
<?php if (!empty($industries)): ?>
<section class="vh-section" style="background-color: var(--color-background-soft);">
    <div class="vh-container">
        <div class="vh-section-header">
            <span class="vh-section-eyebrow">Enterprise & Institutional</span>
            <h2 class="vh-section-title">Industry Solutions</h2>
            <p class="vh-section-desc">Turnkey contract furniture manufacturing for high-traffic environments across India.</p>
        </div>

        <div class="vh-solutions-grid">
            <?php foreach ($industries as $ind): ?>
            <div class="vh-solution-card">
                <span class="vh-solution-icon"><?= $ind['icon'] ?? '🏢' ?></span>
                <h3 class="vh-solution-title"><?= htmlspecialchars($ind['name']) ?></h3>
                <p class="vh-solution-desc"><?= htmlspecialchars($ind['description']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 7. About VISTAHOMZ Section -->
<section class="vh-about-section">
    <div class="vh-container">
        <div class="vh-about-grid">
            <div class="vh-about-content">
                <span class="vh-section-eyebrow" style="color: var(--color-gold-light);">The VISTAHOMZ Legacy</span>
                <h2>Architectural Form Meets Uncompromising Comfort</h2>
                <p class="vh-about-text">
                    At VISTAHOMZ, we create furniture that defines the essence of space. Every piece is precision-crafted using sustainably sourced hardwoods, aircraft-grade structural steel, and hand-finished upholstery designed for longevity.
                </p>
                <div class="vh-about-stats">
                    <div>
                        <div class="vh-stat-num">700+</div>
                        <div class="vh-stat-label">Product Blueprints</div>
                    </div>
                    <div>
                        <div class="vh-stat-num">100%</div>
                        <div class="vh-stat-label">In-House Quality</div>
                    </div>
                    <div>
                        <div class="vh-stat-num">Pan-India</div>
                        <div class="vh-stat-label">Installation Network</div>
                    </div>
                </div>
                <div style="margin-top: 36px;">
                    <a href="about.php" class="vh-btn vh-btn-gold">
                        <span>Read Our Story</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="vh-about-img-box">
                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800&q=80" alt="VISTAHOMZ Workshop & Showroom" style="width: 100%; height: 440px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- 8. Testimonials Section -->
<?php if (!empty($testimonials)): ?>
<section class="vh-section">
    <div class="vh-container">
        <div class="vh-section-header">
            <span class="vh-section-eyebrow">Client Endorsements</span>
            <h2 class="vh-section-title">Trusted by Leaders</h2>
            <p class="vh-section-desc">Hear directly from homeowners, architects, and corporate procurement directors.</p>
        </div>

        <div class="vh-testimonial-grid">
            <?php foreach ($testimonials as $t): ?>
            <div class="vh-testimonial-card">
                <div class="vh-stars">
                    <?php for ($s = 0; $s < (int)($t['rating'] ?? 5); $s++): ?>
                        <i class="bi bi-star-fill"></i>
                    <?php endfor; ?>
                </div>
                <p class="vh-testimonial-quote">"<?= htmlspecialchars($t['review']) ?>"</p>
                <div class="vh-testimonial-author">
                    <div class="vh-author-name"><?= htmlspecialchars($t['name']) ?></div>
                    <div class="vh-author-meta"><?= htmlspecialchars($t['company'] ?? '') ?><?= !empty($t['location']) ? ', ' . htmlspecialchars($t['location']) : '' ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 9. Bottom CTA Section -->
<section class="vh-section" style="padding-top: 0;">
    <div class="vh-container">
        <div class="vh-cta-banner">
            <span class="vh-section-eyebrow" style="color: var(--color-gold-light);">Start Your Project</span>
            <h2>Ready to Transform Your Living or Work Space?</h2>
            <p>
                Request custom catalog pricing, material swatches, or schedule a consultation with our design engineers.
            </p>
            <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                <button type="button" class="vh-btn vh-btn-gold vh-btn-lg" onclick="openQuoteModal()">
                    <i class="bi bi-chat-quote-fill"></i>
                    <span>Request Free Custom Quote</span>
                </button>
                <a href="contact.php" class="vh-btn vh-btn-outline vh-btn-lg" style="color: #fff; border-color: rgba(255,255,255,0.3);">
                    <span>Contact Showroom</span>
                    <i class="bi bi-geo-alt"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
