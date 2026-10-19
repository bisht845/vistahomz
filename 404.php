<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';
$page_title = '404 — Page Not Found';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="vh-container" style="text-align: center; padding: 100px 24px 120px;">
    <h1 style="font-size: 80px; font-family: var(--font-display); color: var(--color-gold); margin: 0;">404</h1>
    <h2 style="margin: 16px 0;">Page Not Found</h2>
    <p style="color: var(--color-text-muted); margin-bottom: 32px;">The furniture suite or collection you are seeking may have moved or been updated.</p>
    <a href="index.php" class="vh-btn vh-btn-gold">Return to Home</a>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
