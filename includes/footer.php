<?php
require_once __DIR__ . '/../functions/settings.php';
$address = get_setting('address', ' Mahavir Enclave, New Delhi – 110059');
$hours = get_setting('business_hours', 'Mon–Sat, 10am–7pm');
$phone1 = get_setting('phone1', '+91 9876543210');
$phone2 = get_setting('phone2', '+91 9876543210');
$email = get_setting('email', 'info@vistahomz.com');
?>
<footer class="vh-footer">
    <div class="vh-container">
        <div class="vh-footer-grid">
            <!-- Brand Column -->
            <div class="vh-footer-brand">
                <img src="assets/images/logo.png" alt="VISTAHOMZ Logo" style="height: 68px; filter: brightness( 0) invert(1);">
                <p>
                    VISTAHOMZ is a premier furniture & architectural living brand specializing in high-grade residential furniture, ergonomic office systems, and turnkey hospitality & commercial bulk orders.
                </p>
                <div style="display: flex; gap: 14px; font-size: 18px;">
                    <a href="#" style="color: var(--color-gold);"><i class="bi bi-instagram"></i></a>
                    <a href="#" style="color: var(--color-gold);"><i class="bi bi-facebook"></i></a>
                    <a href="#" style="color: var(--color-gold);"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" style="color: var(--color-gold);"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Categories -->
            <div class="vh-footer-col">
                <h4>Collections</h4>
                <ul class="vh-footer-links">
                    <li><a href="category.php?cat=living">Living Room Sets</a></li>
                    <li><a href="category.php?cat=dining">Dining Tables & Chairs</a></li>
                    <li><a href="category.php?cat=bedroom">King & Queen Beds</a></li>
                    <li><a href="category.php?cat=office">Office Workstations</a></li>
                    <li><a href="category.php?cat=commercial">Hospitality Solutions</a></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="vh-footer-col">
                <h4>Quick Links</h4>
                <ul class="vh-footer-links">
                    <li><a href="about.php">About VISTAHOMZ</a></li>
                    <li><a href="contact.php">Contact Showroom</a></li>
                    <li><a href="cart.php">Inquiry Cart</a></li>
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="terms-conditions.php">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Contact & Hours -->
            <div class="vh-footer-col">
                <h4>Showroom & Office</h4>
                <p style="font-size: 13px; margin-bottom: 12px; color: rgba(255,255,255,0.8);">
                    <i class="bi bi-geo-alt-fill text-gold" style="color: var(--color-gold); margin-right: 6px;"></i>
                    <?= htmlspecialchars($address) ?>
                </p>
                <p style="font-size: 13px; margin-bottom: 8px;">
                    <i class="bi bi-telephone-fill" style="color: var(--color-gold); margin-right: 6px;"></i>
                    <?= htmlspecialchars($phone1) ?>, <?= htmlspecialchars($phone2) ?>
                </p>
                <p style="font-size: 13px; margin-bottom: 8px;">
                    <i class="bi bi-clock-fill" style="color: var(--color-gold); margin-right: 6px;"></i>
                    <?= htmlspecialchars($hours) ?>
                </p>
                <p style="font-size: 13px; margin: 0;">
                    <i class="bi bi-envelope-fill" style="color: var(--color-gold); margin-right: 6px;"></i>
                    <?= htmlspecialchars($email) ?>
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="vh-footer-bottom">
            <div>
                &copy; <?= date('Y') ?> <strong>VISTAHOMZ</strong>. All Rights Reserved. Crafted with distinction.
            </div>
            <div style="color: rgba(255,255,255,0.5);">
                Pan-India Delivery & Installation | Residential & Commercial
            </div>
        </div>
    </div>
</footer>

<!-- Quote Modal -->
<?php include __DIR__ . '/quote-modal.php'; ?>

<!-- Scripts -->
<script src="assets/js/main.js"></script>
<script src="assets/js/cart.js"></script>
</body>
</html>
