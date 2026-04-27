<?php
require_once __DIR__ . '/../koneksi.php';
$designer_id_side = $_SESSION['user_id'] ?? ($_GET['designer_id'] ?? 3);
$designer_full_name = "Elena Vanhoutte";
$designer_initials = "EV";
$qs = mysqli_query($koneksi, "SELECT full_name FROM users WHERE id = $designer_id_side");
if ($qs && mysqli_num_rows($qs) > 0) {
    $designer_full_name = trim(mysqli_fetch_assoc($qs)['full_name']);
    if (empty($designer_full_name)) $designer_full_name = "Designer";
    $words = explode(" ", $designer_full_name);
    $designer_initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
}
?>
<div class="ds-sidebar">
    <div class="ds-sidebar-brand" style="margin-bottom: 24px;">
        <h2>BANTAR</h2>
        <span style="color: var(--accent-gold);">DESIGNER STUDIO</span>
    </div>
    
    <div style="padding: 0 24px 24px 24px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <div style="width: 32px; height: 32px; border-radius: 50%; background: #E5C158; color: #000; display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: var(--font-heading);">
            <?= $designer_initials ?>
        </div>
        <div>
            <div style="font-size: 13px; font-weight: 600; color: #fff;"><?= htmlspecialchars($designer_full_name) ?></div>
            <div style="font-size: 9px; color: var(--text-secondary); letter-spacing: 1px;">DESIGNER</div>
        </div>
    </div>

    <ul class="ds-nav">
        <li class="ds-nav-item <?php echo $page == 'dashboard-desainer' ? 'active' : ''; ?>">
            <a href="index.php?page=dashboard-desainer" class="ds-nav-link">
                <i class="ph-fill ph-chart-pie-slice"></i>
                STUDIO DASHBOARD
            </a>
        </li>
        <li class="ds-nav-item <?php echo $page == 'history-desainer' ? 'active' : ''; ?>">
            <a href="index.php?page=history-desainer" class="ds-nav-link">
                <i class="ph ph-receipt"></i>
                ROYALTY HISTORY
            </a>
        </li>
    </ul>


    <ul class="ds-nav" style="flex: 0; padding-top: 16px;">
        <li class="ds-nav-item">
            <a href="index.php?page=login" class="ds-nav-link" style="color: #F44336;">
                <i class="ph ph-sign-out"></i>
                SIGN OUT
            </a>
        </li>
    </ul>
</div>
