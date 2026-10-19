<?php
/**
 * Categories Helper
 */
function get_active_categories() {
    global $pdo;
    if (!$pdo) return [];
    try {
        $stmt = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

function get_collections() {
    global $pdo;
    if (!$pdo) return [];
    try {
        $stmt = $pdo->query("SELECT * FROM collections WHERE is_active = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Get categories for the admin product form.
 */
function getAllCategories(bool $includeInactive = false): array {
    global $pdo;

    if (!$pdo) {
        return [];
    }

    $sql = "SELECT * FROM categories";

    if (!$includeInactive) {
        $sql .= " WHERE is_active = 1";
    }

    $sql .= " ORDER BY sort_order ASC, name ASC";

    return $pdo->query($sql)->fetchAll();
}

/**
 * Get collections for the admin product form.
 */
function getAllCollections(bool $includeInactive = false): array {
    global $pdo;

    if (!$pdo) {
        return [];
    }

    $sql = "SELECT * FROM collections";

    if (!$includeInactive) {
        $sql .= " WHERE is_active = 1";
    }

    $sql .= " ORDER BY sort_order ASC";

    return $pdo->query($sql)->fetchAll();
}

/**
 * Get subcategories belonging to a category.
 */
function getSubcategoriesByCategory(int $categoryId): array {
    global $pdo;

    if (!$pdo) {
        return [];
    }

    $stmt = $pdo->prepare(
        "SELECT * FROM subcategories
         WHERE category_id = :category_id
         ORDER BY sort_order ASC, name ASC"
    );

    $stmt->execute([':category_id' => $categoryId]);

    return $stmt->fetchAll();
}