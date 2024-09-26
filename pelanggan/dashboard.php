<?php
session_start(); // Mulai sesi
$title = "Dashboard | Penyewaan Skuter";
require_once '../koneksi.php';


// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pelanggan'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Ambil data pengguna dari sesi
$pelanggan = $_SESSION['pelanggan'];
include 'header.php';
?>
<main id="main">
    <!-- Page content goes here -->
</main><!-- End #main -->
<?php include 'footer.php'; ?>