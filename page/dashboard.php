<link rel="stylesheet" href="css/dashboard.css">
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<!-- Override Bootstrap's container padding for this specific page so dashboard takes full width -->
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
        <?php include 'components/header.php'; ?>
        <?php include 'components/main.php'; ?>
        <?php include 'components/footer.php'; ?>
    </div>
</div>