<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/tambah-busana.css">
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
        <?php include 'components/header.php'; ?> <!-- Actually header needs "Form Tambah Busana" text, let's just make it in components/tambah-busana.php -->
        <div class="ds-header">
            <h2 class="ds-header-title">Form Tambah Busana</h2>
            <div class="ds-header-actions">
                <i class="ph-fill ph-bell ds-header-bell"></i>
                <img src="assets/profile_avatar.png" alt="Profile" class="ds-header-profile">
            </div>
        </div>
        <?php include 'components/tambah-busana.php'; ?>
        <?php include 'components/footer.php'; ?>
    </div>
</div>
