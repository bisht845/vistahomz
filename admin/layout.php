<?php
/**
 * NOVAHOMZ Admin — Shared Layout Include
 * Set $admin_page_title and $admin_active before including
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../functions/uploads.php';
requireAdminLogin();

$admin     = currentAdmin();
$a_title   = $admin_page_title ?? 'Dashboard';
$a_active  = $admin_active ?? '';

// Unread counts
require_once __DIR__ . '/../functions/inquiries.php';
$unread_inq = countUnreadInquiries();
$unread_msg = countUnreadMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($a_title); ?> — VISTAHOMZ Admin</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>/assets/images/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root { --brown:#a56a4f; --brown-dark:#7a4a35; --beige:#f5f0eb; --sidebar-w:250px; }
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f4f6f9; margin: 0; }

    /* SIDEBAR */
    .adm-sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh; background: #1c1c1c; overflow-y: auto; z-index: 100; display: flex; flex-direction: column; }
    .adm-sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 12px; }
    .adm-sidebar-logo img { width: 40px; height: 40px; border-radius: 8px; }
    .adm-sidebar-logo span { color: #fff; font-weight: 800; font-size: 1rem; letter-spacing: 0.06em; }
    .adm-sidebar-logo small { display: block; color: rgba(255,255,255,0.4); font-size: 0.68rem; font-weight: 400; letter-spacing: 0.05em; text-transform: uppercase; }
    .adm-nav { flex: 1; padding: 16px 0; }
    .adm-nav-section { padding: 8px 20px 4px; color: rgba(255,255,255,0.3); font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; }
    .adm-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,0.65); text-decoration: none; font-size: 0.875rem; transition: all 0.15s; border-left: 3px solid transparent; }
    .adm-nav a:hover { color: #fff; background: rgba(255,255,255,0.06); }
    .adm-nav a.active { color: #fff; background: rgba(165,106,79,0.2); border-left-color: var(--brown); }
    .adm-nav a i { font-size: 1rem; opacity: 0.8; }
    .adm-badge { background: var(--brown); color: #fff; font-size: 0.65rem; font-weight: 700; padding: 2px 7px; border-radius: 50px; margin-left: auto; }
    .adm-sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
    .adm-sidebar-footer a { display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.5); font-size: 0.82rem; text-decoration: none; }
    .adm-sidebar-footer a:hover { color: #fff; }

    /* MAIN */
    .adm-main { margin-left: var(--sidebar-w); min-height: 100vh; }
    .adm-topbar { background: #fff; border-bottom: 1px solid #e8e8e8; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
    .adm-topbar-title { font-weight: 700; font-size: 1.05rem; color: #1a1a1a; }
    .adm-topbar-right { display: flex; align-items: center; gap: 16px; }
    .adm-admin-chip { display: flex; align-items: center; gap: 8px; background: var(--beige); padding: 6px 14px; border-radius: 50px; font-size: 0.82rem; font-weight: 600; }
    .adm-admin-chip span { width: 28px; height: 28px; background: var(--brown); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.8rem; font-weight: 700; }
    .adm-content { padding: 28px; }

    /* Cards */
    .stat-card { background: #fff; border-radius: 14px; padding: 22px 24px; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
    .stat-card .stat-val { font-size: 2rem; font-weight: 800; color: var(--brown); }
    .stat-card .stat-label { font-size: 0.8rem; color: #888; font-weight: 600; margin-top: 4px; }
    .stat-card .stat-icon { width: 46px; height: 46px; border-radius: 12px; background: rgba(165,106,79,0.12); display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
    .stat-card .stat-icon i { font-size: 1.3rem; color: var(--brown); }

    /* Table */
    .adm-table { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
    .adm-table table { width: 100%; border-collapse: collapse; }
    .adm-table thead th { background: var(--beige); padding: 12px 16px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #666; text-align: left; }
    .adm-table tbody td { padding: 13px 16px; font-size: 0.875rem; color: #333; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
    .adm-table tbody tr:last-child td { border-bottom: none; }
    .adm-table tbody tr:hover { background: #fafafa; }

    /* Form */
    .adm-card { background: #fff; border-radius: 14px; padding: 28px; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
    .adm-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #666; display: block; margin-bottom: 7px; }
    .adm-input { width: 100%; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 9px; font-size: 0.88rem; outline: none; transition: border-color 0.2s; }
    .adm-input:focus { border-color: var(--brown); }
    .adm-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 20px; border-radius: 9px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; }
    .adm-btn-primary { background: var(--brown); color: #fff; }
    .adm-btn-primary:hover { background: var(--brown-dark); color: #fff; }
    .adm-btn-danger { background: #c00; color: #fff; }
    .adm-btn-danger:hover { background: #900; color: #fff; }
    .adm-btn-secondary { background: #f0f0f0; color: #333; }
    .adm-btn-secondary:hover { background: #e0e0e0; color: #333; }
    .adm-btn-sm { padding: 5px 12px; font-size: 0.78rem; }
    .badge-active { background: rgba(25,180,80,0.12); color: #12a04a; padding: 4px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700; }
    .badge-inactive { background: rgba(200,0,0,0.1); color: #c00; padding: 4px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700; }
    .badge-pending { background: rgba(245,160,0,0.12); color: #c87800; padding: 4px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700; }
    .adm-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .adm-page-header h1 { font-size: 1.4rem; font-weight: 800; margin: 0; }

    @media (max-width: 768px) {
      .adm-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
      .adm-sidebar.open { transform: translateX(0); }
      .adm-main { margin-left: 0; }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="adm-sidebar">
  <div class="adm-sidebar-logo">
    <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="NOVAHOMZ">
    <div>
      <span>VISTAHOMZ</span>
      <small>Admin Panel</small>
    </div>
  </div>

  <nav class="adm-nav">
    <div class="adm-nav-section">Main</div>
    <a href="<?php echo BASE_URL; ?>/admin/dashboard.php" class="<?php echo $a_active === 'dashboard' ? 'active' : ''; ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="adm-nav-section">Catalogue</div>
    <a href="<?php echo BASE_URL; ?>/admin/products/index.php" class="<?php echo $a_active === 'products' ? 'active' : ''; ?>">
      <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/categories/index.php" class="<?php echo $a_active === 'categories' ? 'active' : ''; ?>">
      <i class="bi bi-grid"></i> Categories
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/subcategories/index.php" class="<?php echo $a_active === 'subcategories' ? 'active' : ''; ?>">
      <i class="bi bi-diagram-3"></i> Sub Categories
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/collections/index.php" class="<?php echo $a_active === 'collections' ? 'active' : ''; ?>">
      <i class="bi bi-collection"></i> Collections
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/banners/index.php" class="<?php echo $a_active === 'banners' ? 'active' : ''; ?>">
      <i class="bi bi-image"></i> Banners
    </a>

    <div class="adm-nav-section">CRM</div>
    <a href="<?php echo BASE_URL; ?>/admin/inquiries/index.php" class="<?php echo $a_active === 'inquiries' ? 'active' : ''; ?>">
      <i class="bi bi-chat-dots"></i> Inquiries
      <?php if ($unread_inq > 0): ?><span class="adm-badge"><?php echo $unread_inq; ?></span><?php endif; ?>
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/inquiries/messages.php" class="<?php echo $a_active === 'messages' ? 'active' : ''; ?>">
      <i class="bi bi-envelope"></i> Messages
      <?php if ($unread_msg > 0): ?><span class="adm-badge"><?php echo $unread_msg; ?></span><?php endif; ?>
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/inquiries/reviews.php" class="<?php echo $a_active === 'reviews' ? 'active' : ''; ?>">
      <i class="bi bi-star"></i> Reviews
    </a>

    <div class="adm-nav-section">Config</div>
    <a href="<?php echo BASE_URL; ?>/admin/settings/index.php" class="<?php echo $a_active === 'settings' ? 'active' : ''; ?>">
      <i class="bi bi-gear"></i> Settings
    </a>
  </nav>

  <div class="adm-sidebar-footer">
    <a href="<?php echo BASE_URL; ?>/index.php" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Website</a>
    <a href="<?php echo BASE_URL; ?>/admin/logout.php" style="margin-top:10px;color:#c44;"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</aside>

<!-- MAIN -->
<main class="adm-main">
  <div class="adm-topbar">
    <div class="adm-topbar-title"><?php echo htmlspecialchars($a_title); ?></div>
    <div class="adm-topbar-right">
      <div class="adm-admin-chip">
        <span><?php echo htmlspecialchars(strtoupper(substr($admin['name'] ?: 'A', 0, 1))); ?></span>
        <?php echo htmlspecialchars($admin['name'] ?: 'Admin'); ?>
      </div>
    </div>
  </div>
  <div class="adm-content">
