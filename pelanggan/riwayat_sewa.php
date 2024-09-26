<?php
session_start();
$title = "Riwayat Pemesanan | Penyewaan Skuter";
require_once '../koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pelanggan'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Ambil ID pelanggan dari session
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Query untuk mendapatkan riwayat pemesanan berdasarkan ID pelanggan
$query_riwayat = "SELECT penyewaan.*, skuter.gambar AS gambar 
                  FROM penyewaan 
                  JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter 
                  WHERE penyewaan.ID_Pelanggan = $id_pelanggan 
                  ORDER BY penyewaan.ID_Penyewaan DESC";
$result_riwayat = mysqli_query($db, $query_riwayat);

include 'header.php';
?>

<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Riwayat Pemesanan</h2>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <?php if (mysqli_num_rows($result_riwayat) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result_riwayat)) : ?>
                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <img src="../uploads/<?php echo $row['gambar']; ?>" class="img-fluid" alt="Bukti Pembayaran">
                                <div class="portfolio-info">
                                    <h4><a target="_blank" href="export_pdf.php?id=<?php echo $row['ID_Penyewaan']; ?>"><?php echo $row['tanggal_sewa']; ?></a></h4>
                                    <p><?php echo $row['durasi_sewa']; ?> Menit</p>
                                    <p><?php echo $row['total_bayar']; ?> Total Bayar</p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-lg-12">
                        <p>Tidak ada riwayat pemesanan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
