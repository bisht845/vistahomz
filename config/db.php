
<?php
/**
 * VISTAHOMZ - Database Connection
 */
if (!defined('BASE_URL')) {
    define('BASE_URL', '/vistahomz');
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vistahomz');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('VistaHomz database error: ' . $e->getMessage());

    if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
        throw $e;
    }

    throw new RuntimeException(
        'Database connection failed. Check the XAMPP MySQL service and database configuration.'
    );
}

function getDB(): PDO
{
    global $pdo;
    return $pdo;
}
