<?php
require_once __DIR__ . '/../koneksi.php';
$header_title = isset($page_title) ? $page_title : "Bara Entertaiment Architect";
$header_initials = "U";
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $qh = mysqli_query($koneksi, "SELECT full_name FROM users WHERE id = $uid");
    if ($qh && mysqli_num_rows($qh) > 0) {
        $fn = trim(mysqli_fetch_assoc($qh)['full_name']);
        if (empty($fn)) $fn = "User";
        $words = explode(" ", $fn);
        $header_initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    }
}
?>
<div class="ds-header">
    <h1 class="ds-header-title"><?php echo htmlspecialchars($header_title); ?></h1>

    <div class="ds-header-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #E5C158; color: #000; display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: var(--font-heading); font-size: 14px;">
                <?= $header_initials ?>
            </div>
        <?php else: ?>
            <a href="index.php?page=login" style="background-color: #E5C158; color: #000; padding: 8px 24px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 13px; letter-spacing: 0.5px; font-family: 'Inter', sans-serif; display: inline-block; transition: transform 0.2s ease;">LOGIN</a>
        <?php endif; ?>
    </div>
</div>