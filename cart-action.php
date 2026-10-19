<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/cart.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$session_id = get_session_id();

if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Database not connected']);
    exit;
}

if ($action === 'add') {
    $product_id = (int)($_POST['product_id'] ?? 0);
    $product_name = $_POST['product_name'] ?? '';
    $product_code = $_POST['product_code'] ?? '';
    $image = $_POST['image'] ?? '';
    $quantity = (int)($_POST['quantity'] ?? 1);

    // Check if already in cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart_items WHERE session_id = ? AND product_id = ?");
    $stmt->execute([$session_id, $product_id]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt2 = $pdo->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE id = ?");
        $stmt2->execute([$quantity, $existing['id']]);
    } else {
        $stmt2 = $pdo->prepare("INSERT INTO cart_items (session_id, product_id, product_name, product_code, image, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt2->execute([$session_id, $product_id, $product_name, $product_code, $image, $quantity]);
    }

    echo json_encode(['success' => true, 'total_items' => get_cart_count()]);
    exit;
}

if ($action === 'update') {
    $cart_id = (int)($_POST['cart_id'] ?? 0);
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND session_id = ?");
    $stmt->execute([$quantity, $cart_id, $session_id]);

    echo json_encode(['success' => true]);
    exit;
}

if ($action === 'remove') {
    $cart_id = (int)($_POST['cart_id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND session_id = ?");
    $stmt->execute([$cart_id, $session_id]);

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
