<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/functions/inquiries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = submit_inquiry($_POST);
    
    // Redirect with notification flag
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    $sep = strpos($referer, '?') !== false ? '&' : '?';
    header("Location: " . $referer . $sep . "quote_sent=1");
    exit;
}

header("Location: index.php");
exit;
