<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/settings.php';

$page_title = 'Contact Showroom & Inquiry Support';
$page_desc = 'Connect with VISTAHOMZ for custom furniture designs, corporate office fitouts, and hospitality partnerships.';

$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'] ?? '',
            $_POST['email'] ?? '',
            $_POST['phone'] ?? '',
            $_POST['subject'] ?? 'Website Inquiry',
            $_POST['message'] ?? ''
        ]);
        $message_sent = true;
    } catch (Exception $e) {}
}

$phone1 = get_setting('phone1', '+91 9876543210');
$phone2 = get_setting('phone2', '+91 74999 49187');
$email = get_setting('email', 'info@vistahomz.com');
$address = get_setting('address', 'Rz-D1/325A, Mahavir Enclave, New Delhi – 110045');
$hours = get_setting('business_hours', 'Mon–Sat, 10am–7pm');

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>


<!-- Contact Hero Section -->
<section class="vh-contact-hero">
    <div class="vh-contact-hero-inner">
        <span class="vh-contact-eyebrow">GET IN TOUCH</span>

        <h1>We’d Love to Hear From You</h1>

        <p>
            Whether it’s a single piece or a full commercial project —
            our team is ready to help.
        </p>

        <!-- <div class="vh-contact-hero-actions">
            <a href="#contact-form" class="vh-contact-primary-btn">
                Contact Us
                <i class="bi bi-arrow-right"></i>
            </a>

            <a
                href="https://wa.me/919876543210?text=Hello%20VISTAHOMZ%2C%20I%20would%20like%20to%20enquire%20about%20your%20furniture."
                target="_blank"
                rel="noopener noreferrer"
                class="vh-contact-whatsapp-btn"
            >
                <i class="bi bi-whatsapp"></i>
                WhatsApp Us
            </a>
        </div> -->
    </div>
</section>


<div class="vh-container" style="padding: 70px 24px 100px;">
    <?php if ($message_sent): ?>
        <div style="background: #e8f5e9; border: 1px solid #81c784; color: #2e7d32; padding: 18px 24px; border-radius: var(--radius-md); margin-bottom: 36px;">
            <i class="bi bi-check-circle-fill" style="margin-right: 8px;"></i>
            Thank you! Your inquiry message has been submitted. Our team will contact you shortly.
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 56px;" class="contact-grid">
        <!-- Contact Form -->
        <div style="background: #fff; padding: 36px; border-radius: var(--radius-large); border: 1px solid var(--color-border); box-shadow: var(--shadow-subtle);">
            <h3 style="font-size: 22px; margin-bottom: 24px;">Send a Direct Message</h3>
            <form action="contact.php" method="POST">
                <div class="vh-form-group">
                    <label class="vh-form-label">Your Name *</label>
                    <input type="text" name="name" class="vh-form-control" required placeholder="Full Name">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="vh-form-group">
                        <label class="vh-form-label">Phone Number *</label>
                        <input type="tel" name="phone" class="vh-form-control" required placeholder="+91 98765 43210">
                    </div>
                    <div class="vh-form-group">
                        <label class="vh-form-label">Email Address *</label>
                        <input type="email" name="email" class="vh-form-control" required placeholder="name@domain.com">
                    </div>
                </div>
                <div class="vh-form-group">
                    <label class="vh-form-label">Subject</label>
                    <input type="text" name="subject" class="vh-form-control" placeholder="e.g. Office Bulk Workstations / Custom Living Set">
                </div>
                <div class="vh-form-group">
                    <label class="vh-form-label">Message Details *</label>
                    <textarea name="message" class="vh-form-control" required placeholder="Tell us about your requirements..."></textarea>
                </div>
                <button type="submit" class="vh-btn vh-btn-gold vh-btn-lg" style="width: 100%;">
                    <span>Send Message</span>
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>

        <!-- Contact Cards -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="vh-trust-item" style="background: #fff; border: 1px solid var(--color-border); padding: 24px;">
                <div class="vh-trust-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                    <h4 class="vh-trust-title">Showroom Address</h4>
                    <p class="vh-trust-desc"><?= htmlspecialchars($address) ?></p>
                </div>
            </div>

            <div class="vh-trust-item" style="background: #fff; border: 1px solid var(--color-border); padding: 24px;">
                <div class="vh-trust-icon"><i class="bi bi-telephone-fill"></i></div>
                <div>
                    <h4 class="vh-trust-title">Phone </h4>
                    <p class="vh-trust-desc">
                        <?= htmlspecialchars($phone1) ?><br>
                        <?= htmlspecialchars($phone2) ?>
                    </p>
                </div>
            </div>
            <a href="https://wa.me/919876543210?text=Hello%20VISTAHOMZ%2C%20I%20would%20like%20to%20enquire%20about%20your%20furniture."
   target="_blank"
   rel="noopener noreferrer"
   style="text-decoration: none; display: block;">

    <div class="vh-trust-item"
         style="background: #25D366; border: 1px solid var(--color-border); padding: 24px; cursor: pointer;">

        <div class="vh-trust-icon"
             style="background-color: #51DC85;">
            <i class="bi bi-whatsapp" style="color: #fff;"></i>
        </div>

        <div>
            <h4 class="vh-trust-title" style="color: #fff;">
                Chat on WhatsApp
            </h4>

            <p class="vh-trust-desc" style="color: #fff;">
                Instant response during business hours
            </p>
        </div>

    </div>
                </a>

            <div class="vh-trust-item" style="background: #fff; border: 1px solid var(--color-border); padding: 24px;">
                <div class="vh-trust-icon"><i class="bi bi-clock-fill"></i></div>
                <div>
                    <h4 class="vh-trust-title">Operating Hours</h4>
                    <p class="vh-trust-desc"><?= htmlspecialchars($hours) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (min-width: 992px) {
    .contact-grid {
        grid-template-columns: 1.3fr 0.7fr !important;
    }
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
