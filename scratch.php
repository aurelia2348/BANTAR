<?php
require 'koneksi.php';
$sql = "ALTER TABLE detail_sewa ADD COLUMN denda_lain DECIMAL(15,2) DEFAULT 0";
if (mysqli_query($koneksi, $sql)) {
    echo "Success adding denda_lain to detail_sewa";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
