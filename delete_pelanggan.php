<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_pelanggan = $_GET['id'];

    // Query SQL untuk menghapus data pelanggan berdasarkan id_pelanggan
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Jika penghapusan berhasil, arahkan kembali ke halaman data_pelanggan.php dengan pesan sukses
        $_SESSION['success_message'] = "Data pelanggan berhasil dihapus.";
        header("Location: data_pelanggan.php");
        exit();
    } else {
        // Jika terjadi kesalahan dalam menghapus, arahkan kembali ke halaman data_pelanggan.php dengan pesan error
        $_SESSION['error_message'] = "Gagal menghapus data pelanggan: " . mysqli_error($db);
        header("Location: data_pelanggan.php");
        exit();
    }
} else {
    // Jika id_pelanggan tidak ditemukan, arahkan kembali ke halaman data_pelanggan.php
    header("Location: data_pelanggan.php");
    exit();
}
?>
