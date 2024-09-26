<?php
session_start();
include 'koneksi.php';

// Periksa apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    echo "Unauthenticated";
    exit();
}

// Periksa apakah parameter ID_Penyewaan dan status_pembayaran diberikan
if (!isset($_POST['id_penyewaan']) || !isset($_POST['status_pembayaran'])) {
    echo "Invalid parameters";
    exit();
}

// Ambil parameter dari POST
$id_penyewaan = $_POST['id_penyewaan'];
$status_pembayaran = $_POST['status_pembayaran'];

// Query untuk memperbarui status pembayaran
$query = "UPDATE penyewaan SET status_pembayaran = '$status_pembayaran' WHERE ID_Penyewaan = '$id_penyewaan'";
$result = mysqli_query($db, $query);

if ($result) {
    echo "Success";
} else {
    echo "Failed: " . mysqli_error($db);
}
?>
