<?php
session_start();
$title = "Skuter | Penyewaan Skuter";
require_once '../koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pelanggan'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Ambil data pengguna dari sesi
$pelanggan = $_SESSION['pelanggan'];

// Query untuk mengambil data skuter dari database beserta data penyewaan
$query = "SELECT skuter.*, penyewaan.mulai_jam, penyewaan.jam_akhir 
          FROM skuter 
          LEFT JOIN penyewaan ON skuter.ID_Skuter = penyewaan.ID_Skuter";
$result = mysqli_query($db, $query);

include 'header.php';
?>
<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Booking</h2>
                <p>Daftar Skuter</p>
            </div>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <?php
                // Perulangan untuk menampilkan informasi skuter
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">

                            <img src="../uploads/<?php echo $row['gambar']; ?>" class="img-fluid" alt="<?php echo $row['Merek']; ?>">

                            <div class="portfolio-info">
                                <h4><?php echo $row['Merek'] . ' ' . $row['Tipe']; ?></h4>
                                <h4><?php echo "Status: " . $row['Status']; ?></h4>
                                <h4><?php echo "Harga: Rp " . number_format($row['Harga'], 2, ',', '.'); ?></h4>

                                <!-- Tombol untuk pesan -->
                                <div class="portfolio-links">
                                    <a href="sewa.php?id_skuter=<?php echo $row['ID_Skuter']; ?>" title="Pesan Skuter"><i class="bx bx-plus"></i></a>
                                </div>
                            </div>

                        </div>
                        <br>
                        <h5><?php echo "Mulai Jam: " . $row['mulai_jam']; ?></h5>
                        <h5><?php echo "Jam Akhir: " . $row['jam_akhir']; ?></h5>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>