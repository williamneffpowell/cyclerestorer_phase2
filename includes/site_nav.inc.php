<?php
// Shared top navigation. Expects auth_check.inc.php to have already run.
$google_linked = false;
$nav_unread_messages = 0;
$nav_is_admin = false;

if (!empty($is_logged_in) && !empty($_SESSION['user_id'])) {
    require __DIR__ . '/dbconnect.inc.php';
    $navLink = mysqli_connect($Host, $User, $Password, $DBName);
    if ($navLink) {
        $navUserID = (int) $_SESSION['user_id'];

        $stmt = mysqli_prepare($navLink, 'SELECT google_sub, is_admin FROM auth_user WHERE userID = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $navUserID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $googleSub, $navAdminValue);
            if (mysqli_stmt_fetch($stmt)) {
                $google_linked = !empty($googleSub);
                $nav_is_admin = ((int)$navAdminValue === 1);
            }
            mysqli_stmt_close($stmt);
        }

        $stmt = mysqli_prepare($navLink, 'SELECT COUNT(*) FROM member_messages WHERE recipient_id = ? AND deleted_by_recipient = 0 AND read_at IS NULL');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $navUserID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $navUnreadCount);
            if (mysqli_stmt_fetch($stmt)) $nav_unread_messages = (int)$navUnreadCount;
            mysqli_stmt_close($stmt);
        }
        mysqli_close($navLink);
    }
}
?>
<div class="cr-nav">
  <div class="cr-nav-inner">
    <a href="/index.php" class="cr-brand">
      <img src="/Images/site-icon.svg" alt="">
      <span>Cyclerestorer</span>
    </a>
    <nav class="cr-nav-links">
      <a href="/pages/before_after.php">Restoration Projects</a>
      <a href="/pages/image_library.php">Image Library</a>
      <a href="/pages/library.php">Member Collections</a>
      <a href="/pages/serial_number_reference.php">Serial Numbers</a>
      <a href="/pages/identify_part.php">Identify a Part</a>
   
      <a href="/pages/restoration_techniques.php">Techniques</a>
      <a href="/pages/links.php">Links</a>
    </nav>
    <div class="cr-nav-account">
      <?php if (!empty($is_logged_in)): ?>
        <a href="/pages/messages.php">Messages<?php if ($nav_unread_messages > 0): ?> (<?php echo $nav_unread_messages; ?>)<?php endif; ?></a>
        <a href="/pages/myaccount.php">My Account</a>
        <?php if ($nav_is_admin): ?>
          <a href="/pages/admin.php">Admin</a>
        <?php endif; ?>
        <?php if ($google_linked): ?>
          <span class="cr-google-status" title="This account is linked to Google">Google Linked</span>
        <?php else: ?>
          <a href="/link_google.php">Link Google</a>
        <?php endif; ?>
        <a href="/logout.php" class="cr-btn-ghost">Log Out</a>
      <?php else: ?>
        <a href="/registration_page.php">Register</a>
        <a href="/login.php" class="cr-btn-ghost">Log In</a>
      <?php endif; ?>
    </div>
  </div>
</div>
