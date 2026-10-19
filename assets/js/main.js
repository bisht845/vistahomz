/**
 * VISTAHOMZ - Main UI Interactions
 */

function toggleMobileMenu() {
    const drawer = document.getElementById('mobileDrawer');
    if (drawer) {
        drawer.classList.toggle('open');
    }
}

function openQuoteModal(productName = '', productCode = '', productId = '') {
    const modal = document.getElementById('quoteModal');
    if (!modal) return;

    const nameInput = document.getElementById('quoteProductName');
    const codeInput = document.getElementById('quoteProductCode');
    const idInput = document.getElementById('quoteProductId');
    const typeInput = document.getElementById('quoteType');
    const titleEl = document.getElementById('modalQuoteTitle');

    if (productName) {
        if (nameInput) nameInput.value = productName;
        if (codeInput) codeInput.value = productCode;
        if (idInput) idInput.value = productId;
        if (typeInput) typeInput.value = 'product';
        if (titleEl) titleEl.innerText = 'Quote for ' + productName;
    } else {
        if (nameInput) nameInput.value = '';
        if (codeInput) codeInput.value = '';
        if (idInput) idInput.value = '';
        if (typeInput) typeInput.value = 'general';
        if (titleEl) titleEl.innerText = 'Request a Quote';
    }

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeQuoteModal() {
    const modal = document.getElementById('quoteModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('quoteModal');
    if (e.target === modal) {
        closeQuoteModal();
    }
});
