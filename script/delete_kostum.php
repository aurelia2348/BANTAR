<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$id = (int)$_POST['id'];

// Get image path before deleting so we can remove the file
$row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT gambar FROM stok_kostum WHERE id = $id"));

$stmt = mysqli_prepare($koneksi, "DELETE FROM stok_kostum WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
    // Optionally remove image file
    if ($row && !empty($row['gambar'])) {
        $file = __DIR__ . '/../' . $row['gambar'];
        if (file_exists($file)) {
            @unlink($file);
        }
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Item not found or already deleted']);
}

mysqli_stmt_close($stmt);
