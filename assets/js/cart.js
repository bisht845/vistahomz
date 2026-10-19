/**
 * VISTAHOMZ - Shopping Cart Interactions
 */

function addToCart(productId, productName, productCode, image = '') {
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('product_id', productId);
    formData.append('product_name', productName);
    formData.append('product_code', productCode);
    formData.append('image', image);

    fetch('cart-action.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('cartBadgeCount');
            if (badge) badge.innerText = data.total_items;
            
            // Show toast feedback
            showToast(productName + ' added to inquiry cart');
        }
    })
    .catch(err => console.error('Cart error:', err));
}

function updateCartQuantity(cartId, quantity) {
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('cart_id', cartId);
    formData.append('quantity', quantity);

    fetch('cart-action.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeFromCart(cartId) {
    if (!confirm('Remove this item from your inquiry cart?')) return;

    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('cart_id', cartId);

    fetch('cart-action.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function showToast(msg) {
    const toast = document.createElement('div');
    toast.className = 'vh-toast';
    toast.innerText = msg;
    toast.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#17191D;color:#fff;padding:12px 24px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.2);z-index:9999;font-size:14px;border-left:3px solid #D8B15E;';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
