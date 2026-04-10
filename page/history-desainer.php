<link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
<link rel="stylesheet" href="css/rental-history.css?v=<?= time(); ?>">
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
    .container.flex-grow-1 {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<div class="dashboard-wrapper">
    <?php include 'components/sidebar-desainer.php'; ?>

    <div class="ds-main">
        <?php 
        $page_title = 'ROYALTY HISTORY';
        include 'components/header.php'; 
        ?>
        <?php include 'components/history-desainer.php'; ?>
        <?php include 'components/footer.php'; ?>
    </div>
</div>
