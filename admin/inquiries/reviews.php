<?php
$admin_page_title = 'Reviews';
$admin_active     = 'reviews';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();
require_once __DIR__ . '/../../functions/uploads.php';

$db = getDB();

if (isset($_GET['approve'])) {
    $db->prepare("UPDATE reviews SET status='approved' WHERE id=:id")->execute([':id'=>$_GET['approve']]);
    header('Location: reviews.php?saved=1'); exit;
}
if (isset($_GET['reject'])) {
    $db->prepare("UPDATE reviews SET status='rejected' WHERE id=:id")->execute([':id'=>$_GET['reject']]);
    header('Location: reviews.php?saved=1'); exit;
}
if (isset($_GET['delete'])) {
    $r = $db->prepare("SELECT * FROM reviews WHERE id=:id"); $r->execute([':id'=>$_GET['delete']]);
    $rev = $r->fetch(); if ($rev && !empty($rev['image'])) deleteUpload($rev['image']);
    $db->prepare("DELETE FROM reviews WHERE id=:id")->execute([':id'=>$_GET['delete']]);
    header('Location: reviews.php?deleted=1'); exit;
}

$status = in_array(($_GET['status'] ?? ''), ['pending', 'approved', 'rejected'], true) ? $_GET['status'] : '';
$where  = $status ? "WHERE r.status = " . $db->quote($status) : '';
$reviews = $db->query(
    "SELECT r.*, p.name AS product_name FROM reviews r
     LEFT JOIN products p ON p.id = r.product_id
     $where ORDER BY r.created_at DESC LIMIT 100"
)->fetchAll();

include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Customer Reviews</h1>
  <div class="d-flex gap-2">
    <?php foreach ([''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $k=>$l): ?>
    <a href="?status=<?php echo $k; ?>" class="adm-btn <?php echo $status===$k?'adm-btn-primary':'adm-btn-secondary'; ?> adm-btn-sm"><?php echo $l; ?></a>
    <?php endforeach; ?>
  </div>
</div>

<?php if (isset($_GET['saved'])): ?><div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Review updated.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="adm-flash" style="background:rgba(200,0,0,0.1);color:#c00;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Review deleted.</div><?php endif; ?>

<div class="adm-table">
  <table>
    <thead><tr><th>Reviewer</th><th>Product</th><th>Rating</th><th>Review</th><th>Status</th><th>Date</th><th style="text-align:right;">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($reviews as $r): ?>
      <tr>
        <td style="font-weight:600;"><?php echo htmlspecialchars($r['name']); ?><br><span style="font-size:0.78rem;color:#888;font-weight:400;"><?php echo htmlspecialchars($r['email'] ?? ''); ?></span></td>
        <td style="font-size:0.82rem;color:#555;"><?php echo htmlspecialchars($r['product_name'] ?? '—'); ?></td>
        <td style="color:#f4b942;"><?php echo str_repeat('★', (int)$r['rating']); ?></td>
        <td style="font-size:0.82rem;max-width:220px;"><?php echo htmlspecialchars(substr($r['review'], 0, 100)) . (strlen($r['review'])>100?'…':''); ?></td>
        <td><?php
          echo match($r['status']) {
            'approved' => '<span class="badge-active">Approved</span>',
            'rejected' => '<span class="badge-inactive">Rejected</span>',
            default    => '<span class="badge-pending">Pending</span>',
          };
        ?></td>
        <td style="font-size:0.78rem;color:#888;"><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
        <td style="text-align:right;">
          <div class="d-flex gap-2 justify-content-end">
            <?php if ($r['status'] !== 'approved'): ?><a href="?approve=<?php echo $r['id']; ?>" class="adm-btn adm-btn-sm" style="background:#12a04a;color:#fff;"><i class="bi bi-check-circle"></i></a><?php endif; ?>
            <?php if ($r['status'] !== 'rejected'): ?><a href="?reject=<?php echo $r['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-x-circle"></i></a><?php endif; ?>
            <a href="?delete=<?php echo $r['id']; ?>" class="adm-btn adm-btn-danger adm-btn-sm" data-confirm="Delete this review?"><i class="bi bi-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($reviews)): ?><tr><td colspan="7" style="text-align:center;padding:40px;color:#888;">No reviews found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layout_footer.php'; ?>
