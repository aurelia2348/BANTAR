<?php

$host = "localhost:3306"; // disesuikan sama portmu le, kamu 3306
$user = "root";
$pass = ""; // kosongin aja le karena password u kosong
$db = "bantar"; // nama databasenya

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}