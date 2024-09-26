<?php
session_start();
require_once '../koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pelanggan'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Pastikan ID skuter tersedia dalam parameter POST
if (!isset($_POST['skuter_id'])) {
    // Jika tidak, kembali ke halaman sebelumnya
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

$pelanggan_id = $_SESSION['pelanggan']['id_pelanggan'];
$skuter_id = $_POST['skuter_id'];
$durasi_sewa = $_POST['durasi_sewa'];
$tanggal_sewa = $_POST['tanggal_sewa'];
$total_bayar = $_POST['total_bayar'];
$mulai_jam = $_POST['mulai_jam'];
$jam_akhir = $_POST['jam_akhir'];
$bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
$status_pembayaran = $_POST['status_pembayaran']; // Ambil status pembayaran dari form

// Validasi bahwa bukti pembayaran telah diunggah
if (empty($bukti_pembayaran)) {
    $_SESSION['error_message'] = "Anda harus mengunggah bukti pembayaran.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Periksa apakah ada pemesanan pada rentang waktu yang sama
$query_cek_pemesanan = "SELECT * FROM penyewaan 
                        WHERE ID_Skuter = $skuter_id 
                        AND tanggal_sewa = '$tanggal_sewa' 
                        AND ((mulai_jam <= '$mulai_jam' AND jam_akhir >= '$mulai_jam') 
                             OR (mulai_jam <= '$jam_akhir' AND jam_akhir >= '$jam_akhir'))";
$result_cek_pemesanan = mysqli_query($db, $query_cek_pemesanan);

if (mysqli_num_rows($result_cek_pemesanan) > 0) {
    // Jika ada pemesanan pada rentang waktu yang sama, kembali ke halaman sebelumnya dengan pesan error
    $_SESSION['error_message'] = "Maaf, waktu yang Anda pilih sudah dipesan. Silakan pilih waktu lain.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Upload file bukti pembayaran
$target_dir = "../bukti_pembayaran/";
$target_file = $target_dir . basename($bukti_pembayaran);
move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file);

// Insert data pemesanan ke tabel penyewaan
$query_insert = "INSERT INTO penyewaan (ID_Pelanggan, ID_Skuter, durasi_sewa, tanggal_sewa, mulai_jam, jam_akhir, total_bayar, bukti_pembayaran, status_pembayaran) 
                 VALUES ($pelanggan_id, $skuter_id, $durasi_sewa, '$tanggal_sewa', '$mulai_jam', '$jam_akhir', $total_bayar, '$bukti_pembayaran', '$status_pembayaran')";
$result_insert = mysqli_query($db, $query_insert);

if ($result_insert) {
    // Jika berhasil disimpan, set pesan sukses
    $_SESSION['success_message'] = "Pemesanan berhasil dibuat.";
    header("Location: sewa.php?id_skuter=$skuter_id");
    exit();
} else {
    // Jika gagal disimpan, kembali ke halaman sebelumnya dengan pesan error
    $_SESSION['error_message'] = "Gagal membuat pemesanan: " . mysqli_error($db);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

?>
