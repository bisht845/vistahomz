<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';
require_once __DIR__ . '/functions/cart.php';

$page_title = 'Inquiry Shopping Cart';
$cart_items = get_cart_items();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div style="background: var(--color-background-soft); padding: 48px 0; border-bottom: 1px solid var(--color-border);">
    <div class="vh-container">
        <h1 style="font-size: 36px; margin-bottom: 8px;">Inquiry Shopping Cart</h1>
        <p style="color: var(--color-text-secondary); margin: 0;">Review selected items before requesting customized volume pricing and project delivery timeline.</p>
    </div>
</div>

<div class="vh-container" style="padding: 56px 24px 90px;">
    <?php if (empty($cart_items)): ?>
        <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-large); border: 1px solid var(--color-border); box-shadow: var(--shadow-subtle);">
            <i class="bi bi-bag-x" style="font-size: 56px; color: var(--color-gold);"></i>
            <h3 style="margin: 20px 0 8px;">Your inquiry cart is empty</h3>
            <p style="color: var(--color-text-muted); margin-bottom: 24px;">Explore our collections to add furniture for quotation.</p>
            <a href="category.php?cat=all" class="vh-btn vh-btn-gold">Explore Furniture Collections</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1fr; gap: 36px;" class="cart-grid">
            <!-- Items Table -->
            <div style="background: #fff; border-radius: var(--radius-card); border: 1px solid var(--color-border); padding: 24px; box-shadow: var(--shadow-subtle);">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--color-border); text-align: left; color: var(--color-text-muted);">
                            <th style="padding-bottom: 12px;">Product</th>
                            <th style="padding-bottom: 12px;">Code</th>
                            <th style="padding-bottom: 12px; text-align: center;">Qty</th>
                            <th style="padding-bottom: 12px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr style="border-bottom: 1px solid var(--color-border);">
                            <td style="padding: 16px 0; display: flex; align-items: center; gap: 14px;">
                                <img src="<?= htmlspecialchars($item['image'] ?? 'assets/images/placeholder.jpg') ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <strong><?= htmlspecialchars($item['product_name']) ?></strong>
                            </td>
                            <td style="color: var(--color-gold); font-weight: 600;"><?= htmlspecialchars($item['product_code']) ?></td>
                            <td style="text-align: center;">
                                <input type="number" min="1" max="100" value="<?= (int)$item['quantity'] ?>" onchange="updateCartQuantity(<?= (int)$item['id'] ?>, this.value)" style="width: 60px; padding: 6px; border: 1px solid var(--color-border); border-radius: 6px; text-align: center;">
                            </td>
                            <td style="text-align: right;">
                                <button type="button" onclick="removeFromCart(<?= (int)$item['id'] ?>)" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 18px;" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary & Submit -->
            <div style="background: var(--color-background-soft); border-radius: var(--radius-card); border: 1px solid var(--color-border); padding: 28px; height: fit-content;">
                <h3 style="font-size: 20px; margin-bottom: 16px; font-family: var(--font-body);">Inquiry Summary</h3>
                <p style="font-size: 13px; color: var(--color-text-secondary); margin-bottom: 24px;">
                    Submitting this cart sends an instant quotation request to our senior project managers. We will review dimensions, delivery address, and apply project bulk discounts.
                </p>
                <button type="button" class="vh-btn vh-btn-gold" style="width: 100%; margin-bottom: 12px;" onclick="openQuoteModal('Inquiry Cart (<?= count($cart_items) ?> items)')">
                    <span>Submit Cart for Free Quote</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
                <a href="category.php?cat=all" class="vh-btn vh-btn-outline" style="width: 100%;">
                    <span>Continue Browsing</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
@media (min-width: 992px) {
    .cart-grid {
        grid-template-columns: 2fr 1fr !important;
    }
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
