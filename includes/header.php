<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../functions/settings.php';
require_once __DIR__ . '/../functions/cart.php';

$site_name = get_setting('site_name', 'VISTAHOMZ');
$site_tagline = get_setting('site_tagline', 'Luxury Furniture & Architectural Living');
$meta_title = isset($page_title) ? $page_title . ' — ' . $site_name : get_setting('meta_title', 'VISTAHOMZ — Premium Commercial & Luxury Home Furniture');
$meta_desc = isset($page_desc) ? $page_desc : get_setting('meta_desc', 'VISTAHOMZ delivers premium furniture solutions for offices, hotels, cafes, institutions and modern residences.');
$announcement_text = get_setting('announcement_bar', 'Free Delivery & Professional Installation Across India');
$phone1 = get_setting('phone1', '+91 9876543210');
$email = get_setting('email', 'info@vistahomz.com');
$cart_count = get_cart_count();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    
    <!-- OpenGraph -->
    <meta property="og:title" content="<?= htmlspecialchars($meta_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:type" content="website">

    <!-- Fonts: Playfair Display + Plus Jakarta Sans + Cinzel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- VISTAHOMZ Core Design System -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
