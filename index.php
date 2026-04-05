<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php 
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; 
$is_dashboard = ($page == 'dashboard' || $page == 'archive' || $page == 'tambah-sewa'); 
?>

<body class="d-flex flex-column min-vh-100 <?php echo $is_dashboard ? 'bg-dark' : ''; ?>">
    <?php if (!$is_dashboard) include 'components/navbar.php'; ?>
    <div class="container flex-grow-1">
        <?php
        if ($page == 'stok') {
            include 'page/stok.php';
        } elseif ($page == 'sewa') {
            include 'page/sewa.php';
        } elseif ($page == 'laporan-keuangan') {
            include 'page/laporan-keuangan.php';
        } elseif ($page == 'login') {
            include 'page/login.php';
        } elseif ($page == 'register') {
            include 'page/register.php';
        } elseif ($page == 'dashboard') {
            include 'page/dashboard.php';
        } elseif ($page == 'archive') {
            include 'page/archive.php';
        } elseif ($page == 'tambah-sewa') {
            include 'page/tambah-sewa.php';
        } else {
            echo "<div class='mt-4'><h2>Halaman tidak ditemukan</h2></div>";
        }
        ?>
    </div>
    <?php if (!$is_dashboard) include 'components/footer.php'; ?>
</body>

</html>