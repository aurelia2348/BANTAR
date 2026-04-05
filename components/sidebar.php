<div class="ds-sidebar">
    <div class="ds-sidebar-brand">
        <h2>BANTAR</h2>
        <span>CURATOR ACCESS</span>
    </div>
    
    <ul class="ds-nav">
        <li class="ds-nav-item <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
            <a href="index.php?page=dashboard" class="ds-nav-link">
                <i class="ph-fill ph-squares-four"></i>
                BANTAR DASHBOARD
            </a>
        </li>
        <li class="ds-nav-item <?php echo $page == 'archive' ? 'active' : ''; ?>">
            <a href="index.php?page=archive" class="ds-nav-link">
                <i class="ph ph-archive-box"></i>
                ARCHIVE CATALOG
            </a>
        </li>
        <li class="ds-nav-item">
            <a href="#" class="ds-nav-link">
                <i class="ph ph-clock-counter-clockwise"></i>
                RENTAL HISTORY
            </a>
        </li>
        <li class="ds-nav-item">
            <a href="#" class="ds-nav-link">
                <i class="ph ph-money"></i>
                FINANCIALS
            </a>
        </li>
        <li class="ds-nav-item">
            <a href="#" class="ds-nav-link">
                <i class="ph ph-chart-line-up"></i>
                ANALYTICS
            </a>
        </li>
    </ul>

    <button class="ds-btn-new" onclick="window.location.href='index.php?page=tambah-sewa'">
        NEW RENTAL
    </button>

    <ul class="ds-nav" style="flex: 0;">
        <li class="ds-nav-item">
            <a href="#" class="ds-nav-link">
                <i class="ph ph-gear"></i>
                SETTINGS
            </a>
        </li>
        <li class="ds-nav-item">
            <a href="#" class="ds-nav-link">
                <i class="ph ph-question"></i>
                SUPPORT
            </a>
        </li>
    </ul>
</div>
