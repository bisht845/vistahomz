<?php
$admin_page_title = 'Contact Messages';
$admin_active     = 'messages';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();

$db = getDB();

if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM contact_messages WHERE id = :id")->execute([':id' => $_GET['delete']]);
    header('Location: messages.php?deleted=1'); exit;
}

$id = (int)($_GET['view'] ?? 0);
$viewed = null;
if ($id) {
    $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = :id")->execute([':id' => $id]);
    $s = $db->prepare("SELECT * FROM contact_messages WHERE id = :id"); $s->execute([':id'=>$id]);
    $viewed = $s->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_replied'])) {
    $db->prepare("UPDATE contact_messages SET is_replied = NOT is_replied WHERE id = :id")->execute([':id' => $_POST['msg_id']]);
    header('Location: messages.php?saved=1'); exit;
}

$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 100")->fetchAll();
include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Contact Messages</h1>
</div>

<?php if (isset($_GET['deleted'])): ?><div class="adm-flash" style="background:rgba(200,0,0,0.1);color:#c00;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Message deleted.</div><?php endif; ?>
<?php if (isset($_GET['saved'])): ?><div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:11px 16px;margin-bottom:16px;">Saved.</div><?php endif; ?>

<?php if ($viewed): ?>
<div class="adm-card mb-4" style="border-left:4px solid var(--brown);">
  <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:16px;">
    <div>
      <h5 style="font-weight:700;margin:0;"><?php echo htmlspecialchars($viewed['name']); ?></h5>
      <div style="font-size:0.82rem;color:#888;"><?php echo date('d M Y, h:i A', strtotime($viewed['created_at'])); ?></div>
    </div>
    <?php echo $viewed['is_replied'] ? '<span class="badge-active">Replied</span>' : '<span class="badge-pending">Pending Reply</span>'; ?>
  </div>
  <div class="row g-2" style="font-size:0.88rem;margin-bottom:16px;">
    <div class="col-md-4"><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($viewed['email']); ?>"><?php echo htmlspecialchars($viewed['email']); ?></a></div>
    <div class="col-md-4"><strong>Phone:</strong> <?php echo htmlspecialchars($viewed['phone'] ?? '—'); ?></div>
    <div class="col-md-4"><strong>Subject:</strong> <?php echo htmlspecialchars($viewed['subject'] ?? '—'); ?></div>
    <div class="col-12"><strong>Message:</strong><div style="background:var(--beige);border-radius:8px;padding:14px;margin-top:6px;"><?php echo nl2br(htmlspecialchars($viewed['message'])); ?></div></div>
  </div>
  <form method="POST" style="display:flex;gap:10px;align-items:center;">
    <input type="hidden" name="msg_id" value="<?php echo $viewed['id']; ?>">
    <button type="submit" name="toggle_replied" class="adm-btn adm-btn-primary adm-btn-sm">
      <?php echo $viewed['is_replied'] ? 'Mark as Unreplied' : 'Mark as Replied'; ?>
    </button>
    <a href="mailto:<?php echo htmlspecialchars($viewed['email']); ?>?subject=Re: <?php echo rawurlencode($viewed['subject'] ?? 'Your Inquiry'); ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-envelope"></i> Reply via Email</a>
    <a href="messages.php" class="adm-btn adm-btn-secondary adm-btn-sm">Close</a>
  </form>
</div>
<?php endif; ?>

<div class="adm-table">
  <table>
    <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Date</th><th style="text-align:right;">Actions</th></tr></thead>
    <tbody>
      <?php foreach ($messages as $m): ?>
      <tr style="<?php echo !$m['is_read'] ? 'background:#fffbf7;font-weight:600;' : ''; ?>">
        <td><?php echo htmlspecialchars($m['name']); ?></td>
        <td style="font-size:0.83rem;"><?php echo htmlspecialchars($m['email']); ?></td>
        <td style="font-size:0.83rem;color:#555;"><?php echo htmlspecialchars($m['subject'] ?? '—'); ?></td>
        <td><?php echo $m['is_replied'] ? '<span class="badge-active">Replied</span>' : ($m['is_read'] ? '<span class="badge-pending">Read</span>' : '<span style="background:#1e3a5f;color:#fff;padding:4px 10px;border-radius:50px;font-size:0.7rem;font-weight:700;">New</span>'); ?></td>
        <td style="font-size:0.78rem;color:#888;"><?php echo date('d M Y', strtotime($m['created_at'])); ?></td>
        <td style="text-align:right;">
          <div class="d-flex gap-2 justify-content-end">
            <a href="?view=<?php echo $m['id']; ?>" class="adm-btn adm-btn-secondary adm-btn-sm"><i class="bi bi-eye"></i></a>
            <a href="?delete=<?php echo $m['id']; ?>" class="adm-btn adm-btn-danger adm-btn-sm" data-confirm="Delete this message?"><i class="bi bi-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($messages)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:#888;">No messages found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layout_footer.php'; ?>
