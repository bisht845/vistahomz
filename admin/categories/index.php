<?php
$admin_page_title = 'Categories';
$admin_active     = 'categories';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();
require_once __DIR__ . '/../../functions/uploads.php';

$db = getDB();

// ── Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $row = $db->prepare("SELECT image FROM categories WHERE id = :id");
    $row->execute([':id' => $_GET['delete']]);
    $cat = $row->fetch();
    if ($cat && !empty($cat['image'])) deleteUpload($cat['image']);
    $db->prepare("DELETE FROM categories WHERE id = :id")->execute([':id' => $_GET['delete']]);
    header('Location: index.php?deleted=1'); exit;
}

// ── Handle Save (Add/Edit)
$edit_cat = null;
if (isset($_GET['edit'])) {
    $s = $db->prepare("SELECT * FROM categories WHERE id = :id");
    $s->execute([':id' => $_GET['edit']]);
    $edit_cat = $s->fetch();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edit_id = (int)($_POST['edit_id'] ?? 0);
    $name    = trim($_POST['name'] ?? '');
    $slug    = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    $desc    = trim($_POST['description'] ?? '');
    $icon    = trim($_POST['icon'] ?? '');
    $sort    = (int)($_POST['sort_order'] ?? 0);
    $active  = isset($_POST['is_active']) ? 1 : 0;
    $nav     = isset($_POST['show_in_nav']) ? 1 : 0;

    if (!$name) $errors[] = 'Category name is required.';

    if (empty($errors)) {
        $image = null;
        if ($edit_id) {
            $r = $db->prepare("SELECT image FROM categories WHERE id = :id"); $r->execute([':id'=>$edit_id]); $image = ($r->fetch())['image'] ?? null;
        }
        if (!empty($_FILES['image']['name'])) {
            $res = uploadImage($_FILES['image'], 'categories');
            if ($res['success']) {
                if (!empty($image)) deleteUpload($image);
                $image = $res['filename'];
            } else {
                $errors[] = $res['error'];
            }
        }
    }

    if (empty($errors)) {
        if ($edit_id) {
            $db->prepare("UPDATE categories SET name=:n, slug=:s, description=:d, icon=:ic, sort_order=:so, is_active=:a, show_in_nav=:nav, image=:img WHERE id=:id")
               ->execute([':n'=>$name,':s'=>$slug,':d'=>$desc,':ic'=>$icon,':so'=>$sort,':a'=>$active,':nav'=>$nav,':img'=>$image,':id'=>$edit_id]);
        } else {
            $db->prepare("INSERT INTO categories (name,slug,description,icon,sort_order,is_active,show_in_nav,image) VALUES (:n,:s,:d,:ic,:so,:a,:nav,:img)")
               ->execute([':n'=>$name,':s'=>$slug,':d'=>$desc,':ic'=>$icon,':so'=>$sort,':a'=>$active,':nav'=>$nav,':img'=>$image??null]);
        }
        header('Location: index.php?saved=1'); exit;
    }
}

$categories = $db->query(
    "SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) AS product_count
     FROM categories c ORDER BY c.sort_order ASC, c.name ASC"
)->fetchAll();

include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Categories</h1>
  <a href="?add=1" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle"></i> Add Category</a>
</div>

<?php if (isset($_GET['saved'])): ?><div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Saved successfully.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="adm-flash" style="background:rgba(200,0,0,0.1);color:#c00;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Category deleted.</div><?php endif; ?>

<?php if (isset($_GET['add']) || $edit_cat): ?>
<!-- Add/Edit Form -->
<div class="adm-card mb-4">
  <h5 style="font-weight:700;margin-bottom:20px;"><?php echo $edit_cat ? 'Edit Category' : 'New Category'; ?></h5>
  <?php foreach ($errors as $e): ?><div style="color:#c00;font-size:0.85rem;margin-bottom:8px;">⚠ <?php echo htmlspecialchars($e); ?></div><?php endforeach; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="edit_id" value="<?php echo $edit_cat['id'] ?? 0; ?>">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="adm-label">Name *</label>
        <input type="text" name="name" class="adm-input" required value="<?php echo htmlspecialchars($edit_cat['name'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
        <label class="adm-label">Slug</label>
        <input type="text" name="slug" class="adm-input" value="<?php echo htmlspecialchars($edit_cat['slug'] ?? ''); ?>" placeholder="auto-generated">
      </div>
      <div class="col-md-3">
        <label class="adm-label">Sort Order</label>
        <input type="number" name="sort_order" class="adm-input" value="<?php echo $edit_cat['sort_order'] ?? 0; ?>">
      </div>
      <div class="col-md-8">
        <label class="adm-label">Description</label>
        <input type="text" name="description" class="adm-input" value="<?php echo htmlspecialchars($edit_cat['description'] ?? ''); ?>">
      </div>
      <div class="col-md-4">
        <label class="adm-label">Bootstrap Icon Class</label>
        <input type="text" name="icon" class="adm-input" value="<?php echo htmlspecialchars($edit_cat['icon'] ?? ''); ?>" placeholder="bi-grid">
      </div>
      <div class="col-md-6">
        <label class="adm-label">Category Image</label>
        <input type="file" name="image" accept="image/*" class="adm-input" style="padding:7px;">
        <?php if (!empty($edit_cat['image'])): ?>
        <div style="margin-top:8px;"><img src="<?php echo htmlspecialchars(getImageUrl($edit_cat['image'])); ?>" style="height:60px;border-radius:8px;" alt=""></div>
        <?php endif; ?>
      </div>
      <div class="col-md-3" style="display:flex;align-items:end;gap:16px;">
        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:0.88rem;">
          <input type="checkbox" name="is_active" value="1" <?php echo ($edit_cat['is_active'] ?? 1) ? 'checked' : ''; ?> style="accent-color:var(--brown);"> Active
        </label>
        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:0.88rem;">
          <input type="checkbox" name="show_in_nav" value="1" <?php echo ($edit_cat['show_in_nav'] ?? 1) ? 'checked' : ''; ?> style="accent-color:var(--brown);"> Show in Nav
        </label>
      </div>
      <div class="col-12 d-flex gap-2">
        <button type="submit" class="adm-btn adm-btn-primary"><i class="bi bi-check-circle"></i> Save Category</button>
        <a href="index.php" class="adm-btn adm-btn-secondary">Cancel</a>
      </div>
    </div>
  </form>
</div>
<?php endif; ?>

<!-- Table -->
<div class="adm-table">
  <table>
    <thead><tr><th>Category</th><th>Slug</th><th>Products</th><th>Nav</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($categories as $c): ?>
      <tr>
        <td style="font-weight:600;"><?php if ($c['icon']): ?><i class="bi <?php echo htmlspecialchars($c['icon']); ?>" style="margin-right:6px;color:var(--brown);"></i><?php endif; ?><?php echo htmlspecialchars($c['name']); ?></td>
        <td><code style="font-size:0.78rem;"><?php echo htmlspecialchars($c['slug']); ?></code></td>
        <td style="color:#666;"><?php echo $c['product_count']; ?></td>
        <td><?php echo $c['show_in_nav'] ? '<span class="badge-active">Yes</span>' : '<span class="badge-inactive">No</span>'; ?></td>
        <td><?php echo $c['is_active'] ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Inactive</span>'; ?></td>
        <td style="text-align:right;">
          <div class="d-flex gap-2 justify-content-end">
            <a href="?edit=<?php echo $c['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-pencil"></i></a>
            <a href="?delete=<?php echo $c['id']; ?>" class="adm-btn adm-btn-danger adm-btn-sm" data-confirm="Delete category '<?php echo addslashes($c['name']); ?>'?"><i class="bi bi-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layout_footer.php'; ?>
