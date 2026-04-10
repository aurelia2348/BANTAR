<?php
$header_title = isset($page_title) ? $page_title : "Bara Entertaiment Architect";
?>
<div class="ds-header">
    <h1 class="ds-header-title"><?php echo htmlspecialchars($header_title); ?></h1>

    <div class="ds-header-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
            <i class="ph-fill ph-bell ds-header-bell"></i>
            <img src="assets/profile_avatar.png" alt="Profile" class="ds-header-profile">
        <?php else: ?>
            <a href="index.php?page=login" style="background-color: #E5C158; color: #000; padding: 8px 24px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 13px; letter-spacing: 0.5px; font-family: 'Inter', sans-serif; display: inline-block; transition: transform 0.2s ease;">LOGIN</a>
        <?php endif; ?>
    </div>
</div>