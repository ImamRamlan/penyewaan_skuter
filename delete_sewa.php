<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Ambil ID Penyewaan dari parameter URL
$id_penyewaan = $_GET['id_penyewaan'];

// Query untuk mendapatkan nama file bukti pembayaran
$query_bukti = "SELECT bukti_pembayaran FROM penyewaan WHERE ID_Penyewaan = $id_penyewaan";
$result_bukti = mysqli_query($db, $query_bukti);
$row_bukti = mysqli_fetch_assoc($result_bukti);
$bukti_pembayaran = $row_bukti['bukti_pembayaran'];

// Hapus data penyewaan dari tabel penyewaan
$query_delete = "DELETE FROM penyewaan WHERE ID_Penyewaan = $id_penyewaan";
$result_delete = mysqli_query($db, $query_delete);

if ($result_delete) {
    // Jika penghapusan data penyewaan berhasil, hapus juga file bukti pembayaran terkait
    if (!empty($bukti_pembayaran)) {
        unlink("bukti_pembayaran/" . $bukti_pembayaran);
    }
    $_SESSION['success_message'] = "Data penyewaan berhasil dihapus.";
    header("Location: data_sewa.php");
    exit();
} else {
    $_SESSION['delete_message'] = "Gagal menghapus data penyewaan.";
    header("Location: data_sewa.php");
    exit();
}
?>
