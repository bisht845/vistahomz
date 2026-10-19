<?php
$admin_page_title = 'Inquiries';
$admin_active     = 'inquiries';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();
require_once __DIR__ . '/../../functions/inquiries.php';

$db   = getDB();
$type = $_GET['type'] ?? '';
$id   = (int)($_GET['view'] ?? 0);
$viewed = null;

// Mark as read when viewing
if ($id) {
    $db->prepare("UPDATE inquiries SET is_read = 1 WHERE id = :id")->execute([':id' => $id]);
    $vs = $db->prepare("SELECT * FROM inquiries WHERE id = :id");
    $vs->execute([':id' => $id]);
    $viewed = $vs->fetch() ?: null;
}

// Handle delete
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM inquiries WHERE id = :id")->execute([':id' => $_GET['delete']]);
    header('Location: index.php?deleted=1'); exit;
}

// Handle admin notes update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_notes'])) {
    $db->prepare("UPDATE inquiries SET admin_notes = :notes, is_replied = :rep WHERE id = :id")
       ->execute([':notes' => trim($_POST['admin_notes'] ?? ''), ':rep' => isset($_POST['is_replied']) ? 1 : 0, ':id' => (int)($_POST['inq_id'] ?? 0)]);
    header('Location: index.php?saved=1'); exit;
}

$inquiries = getInquiries(50, 0, $type);
include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Product Inquiries</h1>
  <div class="d-flex gap-2">
    <?php foreach ([''=>'All','product'=>'Product','bulk'=>'Bulk','whatsapp'=>'WhatsApp','general'=>'General'] as $k=>$l): ?>
    <a href="?type=<?php echo $k; ?>" class="adm-btn <?php echo $type===$k?'adm-btn-primary':'adm-btn-secondary'; ?> adm-btn-sm"><?php echo $l; ?></a>
    <?php endforeach; ?>
  </div>
</div>

<?php if (isset($_GET['saved'])): ?><div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Notes saved.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="adm-flash" style="background:rgba(200,0,0,0.1);color:#c00;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Inquiry deleted.</div><?php endif; ?>

<!-- View Single -->
<?php if ($viewed): ?>
<div class="adm-card mb-4" style="border-left:4px solid var(--brown);">
  <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:20px;">
    <div>
      <h5 style="font-weight:700;margin:0;"><?php echo htmlspecialchars($viewed['name']); ?></h5>
      <div style="color:#888;font-size:0.82rem;margin-top:4px;"><?php echo date('d M Y, h:i A', strtotime($viewed['created_at'])); ?></div>
    </div>
    <span class="badge-pending"><?php echo ucfirst($viewed['type']); ?></span>
  </div>
  <div class="row g-3" style="font-size:0.88rem;margin-bottom:20px;">
    <div class="col-md-4"><strong>Phone:</strong> <?php echo htmlspecialchars($viewed['phone']); ?></div>
    <div class="col-md-4"><strong>Email:</strong> <?php echo htmlspecialchars($viewed['email'] ?? '—'); ?></div>
    <?php if ($viewed['product_name']): ?>
    <div class="col-md-4"><strong>Product:</strong> <?php echo htmlspecialchars($viewed['product_name']); ?> (<?php echo htmlspecialchars($viewed['product_code']); ?>)</div>
    <?php endif; ?>
    <?php if ($viewed['message']): ?>
    <div class="col-12"><strong>Message:</strong><br><div style="background:var(--beige);border-radius:8px;padding:12px;margin-top:6px;"><?php echo nl2br(htmlspecialchars($viewed['message'])); ?></div></div>
    <?php endif; ?>
  </div>
  <form method="POST">
    <input type="hidden" name="inq_id" value="<?php echo $viewed['id']; ?>">
    <label class="adm-label">Admin Notes</label>
    <textarea name="admin_notes" class="adm-input" rows="3" style="margin-bottom:10px;"><?php echo htmlspecialchars($viewed['admin_notes'] ?? ''); ?></textarea>
    <div style="display:flex;align-items:center;gap:14px;">
      <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:0.88rem;">
        <input type="checkbox" name="is_replied" value="1" <?php echo $viewed['is_replied'] ? 'checked' : ''; ?> style="accent-color:var(--brown);"> Mark as Replied
      </label>
      <button type="submit" name="save_notes" class="adm-btn adm-btn-primary adm-btn-sm">Save Notes</button>
      <a href="index.php" class="adm-btn adm-btn-secondary adm-btn-sm">Close</a>
    </div>
  </form>
</div>
<?php endif; ?>

<div class="adm-table">
  <table>
    <thead><tr><th>Name</th><th>Contact</th><th>Product</th><th>Type</th><th>Status</th><th>Date</th><th style="text-align:right;">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($inquiries as $inq): ?>
      <tr style="<?php echo !$inq['is_read'] ? 'background:#fffbf7;font-weight:600;' : ''; ?>">
        <td><?php echo htmlspecialchars($inq['name']); ?></td>
        <td style="font-size:0.82rem;"><?php echo htmlspecialchars($inq['phone']); ?><?php if ($inq['email']): ?><br><span style="color:#888;"><?php echo htmlspecialchars($inq['email']); ?></span><?php endif; ?></td>
        <td style="font-size:0.82rem;color:#666;"><?php echo $inq['product_name'] ? htmlspecialchars($inq['product_name']) . '<br><code>' . htmlspecialchars($inq['product_code']) . '</code>' : '—'; ?></td>
        <td><span class="badge-pending"><?php echo ucfirst($inq['type']); ?></span></td>
        <td><?php echo $inq['is_replied'] ? '<span class="badge-active">Replied</span>' : ($inq['is_read'] ? '<span class="badge-pending">Read</span>' : '<span style="background:#1e3a5f;color:#fff;padding:4px 10px;border-radius:50px;font-size:0.7rem;font-weight:700;">New</span>'); ?></td>
        <td style="font-size:0.78rem;color:#888;"><?php echo date('d M Y', strtotime($inq['created_at'])); ?></td>
        <td style="text-align:right;">
          <div class="d-flex gap-2 justify-content-end">
            <a href="?view=<?php echo $inq['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-eye"></i></a>
            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/','',$inq['phone']); ?>" target="_blank" class="adm-btn adm-btn-sm" style="background:#25d366;color:#fff;"><i class="bi bi-whatsapp"></i></a>
            <a href="?delete=<?php echo $inq['id']; ?>" class="adm-btn adm-btn-danger adm-btn-sm" data-confirm="Delete this inquiry?"><i class="bi bi-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($inquiries)): ?><tr><td colspan="7" style="text-align:center;padding:40px;color:#888;">No inquiries found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layout_footer.php'; ?>
