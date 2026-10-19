<?php
$admin_page_title = 'Products';
$admin_active     = 'products';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../functions/uploads.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $db = getDB();
    $del_id = (int)$_GET['delete'];
    // Delete images from disk
    $imgs = $db->prepare("SELECT image FROM product_images WHERE product_id = :id");
    $imgs->execute([':id' => $del_id]);
    foreach ($imgs->fetchAll() as $img) deleteUpload($img['image']);
    // Remove child rows first so nothing is left orphaned if the database has no cascading keys
    $db->prepare("DELETE FROM product_images WHERE product_id = :id")->execute([':id' => $del_id]);
    $db->prepare("DELETE FROM product_features WHERE product_id = :id")->execute([':id' => $del_id]);
    $db->prepare("DELETE FROM products WHERE id = :id")->execute([':id' => $del_id]);
    header('Location: index.php?deleted=1'); exit;
}

$db   = getDB();
$page = max(1, (int)($_GET['page'] ?? 1));
$per  = 20;
$off  = ($page - 1) * $per;
$q    = trim($_GET['q'] ?? '');
$cat  = (int)($_GET['cat'] ?? 0);

$where  = [];
$params = [];
// Each named placeholder may only be used once (native prepared statements), so use two.
if ($q !== '') { $where[] = '(p.name LIKE :q_name OR p.product_code LIKE :q_code)'; $params[':q_name'] = "%$q%"; $params[':q_code'] = "%$q%"; }
if ($cat) { $where[] = 'p.category_id = :cat'; $params[':cat'] = $cat; }
$wh = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$count_stmt = $db->prepare("SELECT COUNT(*) FROM products p $wh");
$count_stmt->execute($params);
$total = (int)$count_stmt->fetchColumn();
$pages = max(1, (int)ceil($total / $per));
if ($page > $pages) { $page = $pages; $off = ($page - 1) * $per; }

$stmt = $db->prepare(
    "SELECT p.*, c.name AS category_name, pi.image AS primary_image
     FROM products p
     LEFT JOIN categories c ON c.id = p.category_id
     LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
     $wh ORDER BY p.created_at DESC, p.id DESC LIMIT :lim OFFSET :off"
);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue(':lim', $per, PDO::PARAM_INT);
$stmt->bindValue(':off', $off, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
$cats     = $db->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Products <span style="font-size:1rem;color:#888;font-weight:400;">(<?php echo $total; ?>)</span></h1>
  <a href="<?php echo BASE_URL; ?>/admin/products/add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
</div>

<?php if (isset($_GET['deleted'])): ?>
<div class="adm-flash" style="background:rgba(200,0,0,0.1);color:#c00;border-radius:9px;padding:11px 16px;margin-bottom:16px;transition:opacity 0.5s;">Product deleted.</div>
<?php endif; ?>
<?php if (isset($_GET['saved'])): ?>
<div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:11px 16px;margin-bottom:16px;transition:opacity 0.5s;">Product saved successfully.</div>
<?php endif; ?>

<!-- Filters -->
<form method="GET" class="adm-card mb-4" style="padding:16px 20px;">
  <div class="row g-2 align-items-end">
    <div class="col-md-5">
      <input type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search by name or code..." class="adm-input">
    </div>
    <div class="col-md-4">
      <select name="cat" class="adm-input">
        <option value="">All Categories</option>
        <?php foreach ($cats as $c): ?>
        <option value="<?php echo $c['id']; ?>" <?php echo $cat === (int)$c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="adm-btn adm-btn-primary" style="width:100%;justify-content:center;"><i class="bi bi-search"></i> Filter</button>
    </div>
  </div>
</form>

<div class="adm-table">
  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Code</th>
        <th>Category</th>
        <th>Flags</th>
        <th>Status</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            <?php if (!empty($p['primary_image'])): ?>
            <img src="<?php echo htmlspecialchars(getImageUrl($p['primary_image'])); ?>" style="width:44px;height:44px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="">
            <?php else: ?>
            <div style="width:44px;height:44px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-image" style="color:#ccc;"></i></div>
            <?php endif; ?>
            <div>
              <div style="font-weight:600;font-size:0.88rem;"><?php echo htmlspecialchars($p['name']); ?></div>
            </div>
          </div>
        </td>
        <td><code style="font-size:0.78rem;background:#f5f5f5;padding:2px 6px;border-radius:4px;"><?php echo htmlspecialchars($p['product_code']); ?></code></td>
        <td style="font-size:0.82rem;color:#666;"><?php echo htmlspecialchars($p['category_name'] ?? '—'); ?></td>
        <td>
          <?php if ($p['is_featured']): ?><span style="background:rgba(165,106,79,0.12);color:var(--brown);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;margin-right:3px;">★ Featured</span><?php endif; ?>
          <?php if ($p['is_new']): ?><span style="background:#e8f5e9;color:#2e7d32;padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;margin-right:3px;">New</span><?php endif; ?>
          <?php if ($p['is_bestseller']): ?><span style="background:#fff3e0;color:#e65100;padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Best Seller</span><?php endif; ?>
        </td>
        <td><?php echo $p['status'] === 'active' ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">' . ucfirst($p['status']) . '</span>'; ?></td>
        <td style="text-align:right;">
          <div class="d-flex gap-2 justify-content-end">
            <a href="<?php echo BASE_URL; ?>/product.php?slug=<?php echo urlencode($p['slug']); ?>" target="_blank" class="adm-btn adm-btn-secondary adm-btn-sm" title="View"><i class="bi bi-eye"></i></a>
            <a href="<?php echo BASE_URL; ?>/admin/products/edit.php?id=<?php echo $p['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
            <a href="?delete=<?php echo $p['id']; ?>" class="adm-btn adm-btn-danger adm-btn-sm"
               data-confirm="Delete '<?php echo addslashes($p['name']); ?>'? This cannot be undone." title="Delete"><i class="bi bi-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($products)): ?>
      <tr><td colspan="6" style="text-align:center;padding:40px;color:#888;">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php if ($pages > 1): ?>
<nav class="mt-4">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
      <a class="page-link" href="?page=<?php echo $i; ?><?php echo $q ? '&q='.urlencode($q) : ''; ?><?php echo $cat ? '&cat='.$cat : ''; ?>"><?php echo $i; ?></a>
    </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php include __DIR__ . '/../layout_footer.php'; ?>
