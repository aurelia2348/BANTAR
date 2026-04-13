<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/settings.css">
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
    .container.flex-grow-1 {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<div class="dashboard-wrapper">
    <?php include 'components/sidebar.php'; ?>
    
    <div class="ds-main">
        <?php 
        $page_title = 'System Settings';
        include 'components/header.php'; 
        ?>
        <?php include 'components/settings.php'; ?>
        <?php include 'components/footer.php'; ?>
    </div>
</div>
