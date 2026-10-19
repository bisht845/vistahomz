<?php
/**
 * Settings Helper
 */
function get_setting($key, $default = '') {
    global $pdo;
    if (!$pdo) {
        $fallbacks = [
            'site_name' => 'VISTAHOMZ',
            'site_tagline' => 'Luxury Furniture & Architectural Living',
            'phone1' => '+91 70427 04454',
            'phone2' => '+91 74999 49187',
            'phone3' => '+91 93541 09802',
            'email' => 'info@novahomz.com',
            'whatsapp' => '917042704454',
            'address' => 'Rz-D1/325A, Mahavir Enclave, New Delhi – 110045',
            'announcement_bar' => 'Free Delivery & Professional Installation Across India',
            'business_hours' => 'Mon–Sat, 10am–7pm'
        ];
        return $fallbacks[$key] ?? $default;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT setting_val FROM settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        return ($val !== false && $val !== null && $val !== '') ? $val : $default;
    } catch (Exception $e) {
        return $default;
    }
}
