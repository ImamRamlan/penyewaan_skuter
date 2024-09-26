<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Pastikan parameter ID Skuter telah diterima
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: data_skuter.php");
    exit();
}

// Ambil ID Skuter dari URL
$id_skuter = $_GET['id'];

// Hapus data skuter berdasarkan ID Skuter
$query = "DELETE FROM skuter WHERE ID_Skuter = '$id_skuter'";
$result = mysqli_query($db, $query);

if ($result) {
    $_SESSION['delete_message'] = "Data skuter berhasil dihapus.";
} else {
    $_SESSION['error_message'] = "Gagal menghapus data skuter: " . mysqli_error($db);
}

// Redirect kembali ke halaman data skuter setelah penghapusan
header("Location: data_skuter.php");
exit();
?>
