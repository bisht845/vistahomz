<?php
$admin_page_title = 'Settings';
$admin_active     = 'settings';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAdminLogin();

$db = getDB();
$saved = false;

// The only keys this form may write (key => label). Keys missing from the table are created on save.
$setting_fields = [
    'site_name' => 'Site Name', 'site_tagline' => 'Site Tagline',
    'phone1' => 'Phone 1', 'phone2' => 'Phone 2', 'phone3' => 'Phone 3',
    'email' => 'Email', 'whatsapp' => 'WhatsApp Number', 'address' => 'Address',
    'business_hours' => 'Business Hours', 'meta_title' => 'Meta Title',
    'meta_desc' => 'Meta Description', 'announcement_bar' => 'Announcement Bar Text',
    'instagram' => 'Instagram URL', 'facebook' => 'Facebook URL', 'youtube' => 'YouTube URL',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['_change_pw'])) {
    $exists = $db->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = :key");
    $update = $db->prepare("UPDATE settings SET setting_val = :val WHERE setting_key = :key");
    $insert = $db->prepare("INSERT INTO settings (setting_key, setting_val, label) VALUES (:key, :val, :label)");
    foreach ($setting_fields as $key => $label) {
        if (!isset($_POST[$key]) || !is_string($_POST[$key])) continue;
        $val = trim($_POST[$key]);
        $exists->execute([':key' => $key]);
        if ((int)$exists->fetchColumn() > 0) {
            $update->execute([':key' => $key, ':val' => $val]);
        } else {
            $insert->execute([':key' => $key, ':val' => $val, ':label' => $label]);
        }
    }
    $saved = true;
}

$settings = [];
foreach ($db->query("SELECT setting_key, setting_val, label FROM settings ORDER BY id ASC")->fetchAll() as $row) {
    $settings[$row['setting_key']] = $row;
}
// Show every field even if its row does not exist yet.
foreach ($setting_fields as $key => $label) {
    if (!isset($settings[$key])) {
        $settings[$key] = ['setting_key' => $key, 'setting_val' => '', 'label' => $label];
    }
}

include __DIR__ . '/../layout.php';
?>

<div class="adm-page-header">
  <h1>Site Settings</h1>
</div>

<?php if ($saved): ?>
<div class="adm-flash" style="background:rgba(25,180,80,0.1);color:#12a04a;border-radius:9px;padding:13px 18px;margin-bottom:20px;">
  <i class="bi bi-check-circle-fill me-2"></i> Settings saved successfully.
</div>
<?php endif; ?>

<form method="POST">
<div class="row g-4">

  <!-- Business Info -->
  <div class="col-lg-6">
    <div class="adm-card">
      <h5 style="font-weight:700;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f0f0;">Business Information</h5>
      <?php foreach (['site_name','site_tagline','phone1','phone2','phone3','email','whatsapp','address','business_hours'] as $key): ?>
      <?php if (!isset($settings[$key])) continue; ?>
      <div class="mb-3">
        <label class="adm-label"><?php echo htmlspecialchars($settings[$key]['label']); ?></label>
        <?php if ($key === 'address'): ?>
        <textarea name="<?php echo $key; ?>" class="adm-input" rows="2"><?php echo htmlspecialchars($settings[$key]['setting_val'] ?? ''); ?></textarea>
        <?php else: ?>
        <input type="text" name="<?php echo $key; ?>" class="adm-input" value="<?php echo htmlspecialchars($settings[$key]['setting_val'] ?? ''); ?>">
        <?php endif; ?>
        <?php if ($key === 'whatsapp'): ?>
        <p style="font-size:0.75rem;color:#888;margin-top:4px;">Include country code, no spaces or +. E.g. 917042704454</p>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- SEO & Social -->
  <div class="col-lg-6">
    <div class="adm-card mb-4">
      <h5 style="font-weight:700;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f0f0;">SEO & Meta</h5>
      <?php foreach (['meta_title','meta_desc','announcement_bar'] as $key): ?>
      <?php if (!isset($settings[$key])) continue; ?>
      <div class="mb-3">
        <label class="adm-label"><?php echo htmlspecialchars($settings[$key]['label']); ?></label>
        <?php if (in_array($key, ['meta_desc'])): ?>
        <textarea name="<?php echo $key; ?>" class="adm-input" rows="3"><?php echo htmlspecialchars($settings[$key]['setting_val'] ?? ''); ?></textarea>
        <?php else: ?>
        <input type="text" name="<?php echo $key; ?>" class="adm-input" value="<?php echo htmlspecialchars($settings[$key]['setting_val'] ?? ''); ?>">
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="adm-card">
      <h5 style="font-weight:700;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f0f0;">Social Media Links</h5>
      <?php foreach (['instagram','facebook','youtube'] as $key): ?>
      <?php if (!isset($settings[$key])) continue; ?>
      <div class="mb-3">
        <label class="adm-label"><?php echo htmlspecialchars($settings[$key]['label']); ?></label>
        <input type="url" name="<?php echo $key; ?>" class="adm-input" value="<?php echo htmlspecialchars($settings[$key]['setting_val'] ?? ''); ?>" placeholder="https://...">
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="col-12">
    <button type="submit" class="adm-btn adm-btn-primary" style="padding:12px 32px;font-size:0.95rem;">
      <i class="bi bi-check-circle"></i> Save All Settings
    </button>
  </div>

</div>
</form>

<!-- Admin Password Change -->
<div class="adm-card mt-4">
  <h5 style="font-weight:700;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f0f0;">Change Admin Password</h5>
  <?php
  $pw_error = ''; $pw_success = false;
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_change_pw'])) {
      $cur  = $_POST['current_pw'] ?? '';
      $new  = $_POST['new_pw'] ?? '';
      $conf = $_POST['confirm_pw'] ?? '';
      $admin = currentAdmin();
      $row = $db->prepare("SELECT password FROM admins WHERE id=:id"); $row->execute([':id'=>$admin['id']]);
      $stored = ($row->fetch())['password'] ?? '';
      if (!password_verify($cur, $stored)) $pw_error = 'Current password is incorrect.';
      elseif (strlen($new) < 8) $pw_error = 'New password must be at least 8 characters.';
      elseif ($new !== $conf) $pw_error = 'Passwords do not match.';
      else {
          $db->prepare("UPDATE admins SET password=:p WHERE id=:id")->execute([':p'=>password_hash($new,PASSWORD_BCRYPT,['cost'=>12]),':id'=>$admin['id']]);
          $pw_success = true;
      }
  }
  ?>
  <?php if ($pw_error): ?><div style="color:#c00;font-size:0.85rem;margin-bottom:12px;"><i class="bi bi-exclamation-circle me-1"></i><?php echo htmlspecialchars($pw_error); ?></div><?php endif; ?>
  <?php if ($pw_success): ?><div style="color:#12a04a;font-size:0.85rem;margin-bottom:12px;"><i class="bi bi-check-circle me-1"></i>Password updated successfully.</div><?php endif; ?>
  <form method="POST">
    <input type="hidden" name="_change_pw" value="1">
    <div class="row g-3">
      <div class="col-md-4"><label class="adm-label">Current Password</label><input type="password" name="current_pw" class="adm-input" required></div>
      <div class="col-md-4"><label class="adm-label">New Password</label><input type="password" name="new_pw" class="adm-input" required></div>
      <div class="col-md-4"><label class="adm-label">Confirm New Password</label><input type="password" name="confirm_pw" class="adm-input" required></div>
      <div class="col-12"><button type="submit" class="adm-btn adm-btn-primary adm-btn-sm"><i class="bi bi-lock"></i> Update Password</button></div>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout_footer.php'; ?>
