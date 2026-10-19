<!-- Quote / Inquiry Modal -->
<div class="vh-modal-overlay" id="quoteModal">
    <div class="vh-modal" role="dialog" aria-modal="true" aria-labelledby="modalQuoteTitle">
        <button type="button" class="vh-modal-close" onclick="closeQuoteModal()" aria-label="Close dialog">&times;</button>
        
        <div style="text-align: center; margin-bottom: 24px;">
            <span class="vh-hero-eyebrow" style="margin-bottom: 6px;">Complimentary Consultation</span>
            <h3 id="modalQuoteTitle" style="font-size: 24px; margin-bottom: 6px;">Request a Quote</h3>
            <p style="font-size: 13px; color: var(--color-text-muted); margin: 0;">
                Tell us about your residential or commercial project. Our team will provide custom pricing within 2 hours.
            </p>
        </div>

        <form action="inquiry-submit.php" method="POST" id="quoteForm">
            <input type="hidden" name="type" id="quoteType" value="general">
            <input type="hidden" name="product_id" id="quoteProductId" value="">
            <input type="hidden" name="product_name" id="quoteProductName" value="">
            <input type="hidden" name="product_code" id="quoteProductCode" value="">

            <div class="vh-form-group">
                <label class="vh-form-label" for="qName">Full Name *</label>
                <input type="text" id="qName" name="name" class="vh-form-control" required placeholder="e.g. Rajesh Sharma">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="vh-form-group">
                    <label class="vh-form-label" for="qPhone">Phone Number *</label>
                    <input type="tel" id="qPhone" name="phone" class="vh-form-control" required placeholder="+91 98765 43210">
                </div>
                <div class="vh-form-group">
                    <label class="vh-form-label" for="qEmail">Email Address</label>
                    <input type="email" id="qEmail" name="email" class="vh-form-control" placeholder="name@company.com">
                </div>
            </div>

            <div class="vh-form-group">
                <label class="vh-form-label" for="qMessage">Requirement Details</label>
                <textarea id="qMessage" name="message" class="vh-form-control" placeholder="Describe the items, quantity, customization, or project specifications..."></textarea>
            </div>

            <button type="submit" class="vh-btn vh-btn-gold" style="width: 100%;">
                <span>Submit Quote Request</span>
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</div>
