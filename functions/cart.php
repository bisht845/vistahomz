<?php
/**
 * Cart Helper
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_session_id() {
    return session_id();
}

function get_cart_count() {
    global $pdo;
    if (!$pdo) return 0;
    try {
        $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart_items WHERE session_id = ?");
        $stmt->execute([get_session_id()]);
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

function get_cart_items() {
    global $pdo;
    if (!$pdo) return [];
    try {
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE session_id = ? ORDER BY id DESC");
        $stmt->execute([get_session_id()]);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}
