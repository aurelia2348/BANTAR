<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

// Accept POST with _method=PUT override (browsers can't send PUT with multipart)
$method = $_SERVER['REQUEST_METHOD'];
$override = $_POST['_method'] ?? '';
if ($method !== 'POST' || strtoupper($override) !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$id               = (int)($_POST['id'] ?? 0);
$nama_designer    = trim($_POST['nama_designer'] ?? '');
$nama_kostum      = trim($_POST['nama_kostum'] ?? '');
$kategori         = trim($_POST['kategori'] ?? '');
$deskripsi        = trim($_POST['deskripsi'] ?? '');
$rental_price     = str_replace(['.', ','], '', $_POST['rental_price'] ?? '0');
$rental_model_price = str_replace(['.', ','], '', $_POST['rental_model_price'] ?? '0');
$jumlah           = (int)($_POST['jumlah'] ?? 0);

if (!$id || !$nama_designer || !$nama_kostum) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Handle optional image upload
$gambar_sql = '';
$gambar_params = [];
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $ext      = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $allowed  = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Format gambar tidak didukung']);
        exit;
    }
    $uploadDir  = __DIR__ . '/../assets/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $filename   = 'kostum_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
        // Delete old image
        $oldRow = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT gambar FROM stok_kostum WHERE id = $id"));
        if ($oldRow && !empty($oldRow['gambar'])) {
            $oldFile = __DIR__ . '/../' . $oldRow['gambar'];
            if (file_exists($oldFile)) @unlink($oldFile);
        }
        $gambar_sql = ', gambar = ?';
        $gambar_params = ['s', 'assets/uploads/' . $filename];
    }
}

// Build query
$sql = "UPDATE stok_kostum SET
    nama_designer = ?,
    nama_kostum   = ?,
    kategori      = ?,
    deskripsi     = ?,
    rental_price  = ?,
    rental_model_price = ?,
    jumlah        = ?
    $gambar_sql
    WHERE id = ?";

$stmt = mysqli_prepare($koneksi, $sql);

if ($gambar_sql) {
    // s s s s d d i s i
    mysqli_stmt_bind_param($stmt, 'ssssddi' . $gambar_params[0] . 'i',
        $nama_designer, $nama_kostum, $kategori, $deskripsi,
        $rental_price, $rental_model_price, $jumlah,
        $gambar_params[1], $id
    );
} else {
    mysqli_stmt_bind_param($stmt, 'ssssddii',
        $nama_designer, $nama_kostum, $kategori, $deskripsi,
        $rental_price, $rental_model_price, $jumlah, $id
    );
}

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Garment berhasil diperbarui']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => mysqli_error($koneksi)]);
}

mysqli_stmt_close($stmt);
