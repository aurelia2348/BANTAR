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
<body class="d-flex flex-column min-vh-100">
    <?php include 'components/navbar.php'; ?>
    <div class="container flex-grow-1">
        <?php 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
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
            } else {
                echo "<div class='mt-4'><h2>Halaman tidak ditemukan</h2></div>";
            }
        } else {
        ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <h1>Hai ini home!</h1>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php include 'components/footer.php'; ?>
</body>
</html>