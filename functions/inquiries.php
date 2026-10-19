<?php
/**
 * Inquiries Helper
 */

function submit_inquiry($data) {
    global $pdo;

    if (!$pdo) {
        return false;
    }

    try {
        $sql = "INSERT INTO inquiries
                (type, product_id, product_name, product_code, name, email, phone, message)
                VALUES
                (:type, :product_id, :product_name, :product_code, :name, :email, :phone, :message)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':type'         => $data['type'] ?? 'general',
            ':product_id'   => !empty($data['product_id']) ? $data['product_id'] : null,
            ':product_name' => $data['product_name'] ?? null,
            ':product_code' => $data['product_code'] ?? null,
            ':name'         => $data['name'] ?? '',
            ':email'        => $data['email'] ?? null,
            ':phone'        => $data['phone'] ?? '',
            ':message'      => $data['message'] ?? ''
        ]);
    } catch (Exception $e) {
        error_log('Inquiry submission error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Count unread inquiries.
 */
function countUnreadInquiries(): int {
    global $pdo;

    if (!$pdo) {
        return 0;
    }

    $stmt = $pdo->query(
        "SELECT COUNT(*) FROM inquiries WHERE is_read = 0"
    );

    return (int) $stmt->fetchColumn();
}

/**
 * Count unread contact messages.
 */
function countUnreadMessages(): int {
    global $pdo;

    if (!$pdo) {
        return 0;
    }

    $stmt = $pdo->query(
        "SELECT COUNT(*) FROM contact_messages WHERE is_read = 0"
    );

    return (int) $stmt->fetchColumn();
}

/**
 * Get inquiries for the admin list (newest first).
 * $type is one of: product, bulk, whatsapp, general (or '' for all).
 */
function getInquiries(int $limit = 50, int $offset = 0, string $type = ''): array {
    global $pdo;

    if (!$pdo) {
        return [];
    }

    $sql = "SELECT * FROM inquiries";
    $validTypes = ['product', 'bulk', 'whatsapp', 'general'];
    $useType = in_array($type, $validTypes, true);

    if ($useType) {
        $sql .= " WHERE type = :type";
    }

    $sql .= " ORDER BY created_at DESC, id DESC LIMIT :lim OFFSET :off";

    $stmt = $pdo->prepare($sql);
    if ($useType) {
        $stmt->bindValue(':type', $type);
    }
    $stmt->bindValue(':lim', max(1, $limit), PDO::PARAM_INT);
    $stmt->bindValue(':off', max(0, $offset), PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}
