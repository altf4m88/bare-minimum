<?php
/**
 * DOKUMENTASI: Membuat koneksi ke database MySQL lokal
 * File ini adalah "Reusable Subroutine" yang disertakan dalam file lain untuk akses database.
 */

$host = "localhost";
$user = "root";
$pass = "";
$db   = "inventory_db";

// Membangun koneksi menggunakan mysqli_connect
$conn = mysqli_connect($host, $user, $pass, $db);

// DEBUGGING: Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
