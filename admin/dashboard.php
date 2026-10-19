<?php
$admin_page_title = 'Dashboard';
$admin_active     = 'dashboard';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../functions/inquiries.php';
require_once __DIR__ . '/../functions/uploads.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdminLogin();
$db = getDB();

$total_products = (int)$db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_cats     = (int)$db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_inq      = (int)$db->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
$total_msg      = (int)$db->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$unread_inq     = countUnreadInquiries();
$unread_msg     = countUnreadMessages();

$recent_products = $db->query(
    "SELECT p.*, c.name AS category_name, pi.image AS primary_image
     FROM products p
     LEFT JOIN categories c ON c.id = p.category_id
     LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
     ORDER BY p.id DESC
     LIMIT 5"
)->fetchAll();

$recent_inq = $db->query(
    "SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 6"
)->fetchAll();

include __DIR__ . '/layout.php';
?>

<!-- Stats Grid -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
      <div class="stat-val"><?php echo $total_products; ?></div>
      <div class="stat-label">Total Products</div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon"><i class="bi bi-chat-dots"></i></div>
      <div class="stat-val"><?php echo $total_inq; ?></div>
      <div class="stat-label">Total Inquiries <?php if ($unread_inq): ?><span class="adm-badge" style="vertical-align:middle;"><?php echo $unread_inq; ?> new</span><?php endif; ?></div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon"><i class="bi bi-envelope"></i></div>
      <div class="stat-val"><?php echo $total_msg; ?></div>
      <div class="stat-label">Contact Messages <?php if ($unread_msg): ?><span class="adm-badge" style="vertical-align:middle;"><?php echo $unread_msg; ?> new</span><?php endif; ?></div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon"><i class="bi bi-grid"></i></div>
      <div class="stat-val"><?php echo $total_cats; ?></div>
      <div class="stat-label">Categories</div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
  <div class="col-12">
    <div class="adm-card" style="padding:20px 24px;">
      <div style="font-weight:700;font-size:0.82rem;text-transform:uppercase;letter-spacing:0.08em;color:#888;margin-bottom:14px;">Quick Actions</div>
      <div class="d-flex gap-2 flex-wrap">
        <a href="<?php echo BASE_URL; ?>/admin/products/add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
        <a href="<?php echo BASE_URL; ?>/admin/categories/add.php" class="adm-btn adm-btn-secondary"><i class="bi bi-plus-circle"></i> Add Category</a>
        <a href="<?php echo BASE_URL; ?>/admin/banners/index.php" class="adm-btn adm-btn-secondary"><i class="bi bi-image"></i> Manage Banners</a>
        <a href="<?php echo BASE_URL; ?>/admin/inquiries/index.php" class="adm-btn adm-btn-secondary"><i class="bi bi-chat-dots"></i> View Inquiries</a>
        <a href="<?php echo BASE_URL; ?>/admin/settings/index.php" class="adm-btn adm-btn-secondary"><i class="bi bi-gear"></i> Settings</a>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Recent Products -->
  <div class="col-lg-7">
    <div class="adm-table">
      <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
        <strong style="font-size:0.95rem;">Recent Products</strong>
        <a href="<?php echo BASE_URL; ?>/admin/products/index.php" style="font-size:0.8rem;color:var(--brown);text-decoration:none;">View All →</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Product</th>
          <th>Code</th>
          <th>Category</th>
          <th>Status</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($recent_products as $p): ?>
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:10px;">
                <?php if (!empty($p['primary_image'])): ?>
                <img src="<?php echo htmlspecialchars(getImageUrl($p['primary_image'])); ?>" style="width:38px;height:38px;object-fit:cover;border-radius:8px;" alt="">
                <?php endif; ?>
                <span style="font-weight:600;font-size:0.85rem;"><?php echo htmlspecialchars($p['name']); ?></span>
              </div>
            </td>
            <td><code style="font-size:0.78rem;"><?php echo htmlspecialchars($p['product_code']); ?></code></td>
            <td style="font-size:0.82rem;color:#666;"><?php echo htmlspecialchars($p['category_name'] ?? '—'); ?></td>
            <td><?php echo $p['status'] === 'active' ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Inactive</span>'; ?></td>
            <td><a href="<?php echo BASE_URL; ?>/admin/products/edit.php?id=<?php echo $p['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-pencil"></i></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Inquiries -->
  <div class="col-lg-5">
    <div class="adm-table">
      <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
        <strong style="font-size:0.95rem;">Recent Inquiries</strong>
        <a href="<?php echo BASE_URL; ?>/admin/inquiries/index.php" style="font-size:0.8rem;color:var(--brown);text-decoration:none;">View All →</a>
      </div>
      <table>
        <thead><tr><th>Name</th><th>Type</th><th>Date</th></tr></thead>
        <tbody>
          <?php foreach ($recent_inq as $inq): ?>
          <tr style="<?php echo !$inq['is_read'] ? 'font-weight:600;' : ''; ?>">
            <td style="font-size:0.85rem;"><?php echo htmlspecialchars($inq['name']); ?></td>
            <td><span class="badge-pending" style="font-size:0.7rem;"><?php echo ucfirst($inq['type']); ?></span></td>
            <td style="font-size:0.78rem;color:#888;"><?php echo date('d M', strtotime($inq['created_at'])); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . '/layout_footer.php'; ?>
