<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Logout user
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Tangkap id karyawan yang akan dihapus dari parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: datakaryawan.php");
    exit();
}
$id_karyawan = $_GET['id'];

// Hapus data karyawan dari database
$query = "DELETE FROM admin WHERE id_admin='$id_karyawan'";
$result = mysqli_query($db, $query);

if ($result) {
    $_SESSION['notification'] = "Data karyawan berhasil dihapus.";
} else {
    $_SESSION['notification'] = "Gagal menghapus data karyawan: " . mysqli_error($db);
}

header("Location: datakaryawan.php");
exit();
?>
