<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();

header('Content-Type: application/json');
$cat_id = (int)($_GET['cat_id'] ?? 0);
if (!$cat_id) { echo '[]'; exit; }

$stmt = getDB()->prepare(
    "SELECT id, name FROM subcategories WHERE category_id = :id AND is_active = 1 ORDER BY sort_order ASC"
);
$stmt->execute([':id' => $cat_id]);
echo json_encode($stmt->fetchAll());
