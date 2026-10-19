<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';

$page_title = 'About VISTAHOMZ — Craftsmanship, Heritage & Design';
$page_desc = 'Learn about VISTAHOMZ, our philosophy of architectural furniture, and turnkey commercial solutions.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div style="background: var(--color-background-soft); padding: 56px 0; border-bottom: 1px solid var(--color-border);">
    <div class="vh-container">
        <span class="vh-hero-eyebrow">Our Philosophy</span>
        <h1 style="font-size: 42px; margin-bottom: 12px;">Crafting Distinction for Modern Spaces</h1>
        <p style="color: var(--color-text-secondary); max-width: 700px; font-size: 17px;">
            VISTAHOMZ bridges the gap between artisanal woodworking and modern precision manufacturing, creating furniture that endures generations.
        </p>
    </div>
</div>

<div class="vh-container" style="padding: 80px 24px 100px;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 56px; align-items: center;" class="about-grid">
        <div>
            <h2 style="font-size: 32px; margin-bottom: 20px;">The VISTAHOMZ Standard</h2>
            <p style="color: var(--color-text-secondary); line-height: 1.8; margin-bottom: 16px;">
                Originating with a passion for architectural aesthetics and ergonomic comfort, VISTAHOMZ provides holistic furniture solutions for private homes, enterprise corporate campuses, boutique hotels, and educational facilities.
            </p>
            <p style="color: var(--color-text-secondary); line-height: 1.8; margin-bottom: 28px;">
                Every collection is born in our state-of-the-art facility using sustainably sourced teak, sheesham, and engineered polymers paired with imported hardware. We guarantee 100% in-house quality inspection before white-glove dispatch.
            </p>
            <div style="display: flex; gap: 24px;">
                <div>
                    <h3 style="color: var(--color-gold); font-size: 32px; margin: 0;">500+</h3>
                    <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">Commercial Projects</p>
                </div>
                <div>
                    <h3 style="color: var(--color-gold); font-size: 32px; margin: 0;">20+</h3>
                    <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">Years Experience</p>
                </div>
                <div>
                    <h3 style="color: var(--color-gold); font-size: 32px; margin: 0;">100%</h3>
                    <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">Installation Guarantee</p>
                </div>
            </div>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800&q=80" alt="VISTAHOMZ Craftsmanship" style="border-radius: var(--radius-large); width: 100%; height: 420px; object-fit: cover; box-shadow: var(--shadow-premium); border: 1px solid var(--color-border);">
        </div>
    </div>
</div>

<style>
@media (min-width: 992px) {
    .about-grid {
        grid-template-columns: 1.1fr 0.9fr !important;
    }
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
