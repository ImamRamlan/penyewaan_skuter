<?php
session_start();
$title = "Sewa Skuter | Penyewaan Skuter";
require_once '../koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pelanggan'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Pastikan ID skuter tersedia dalam parameter URL
if (!isset($_GET['id_skuter'])) {
    // Jika tidak, kembalikan pengguna ke halaman skuter.php
    header("Location: skuter.php");
    exit();
}

$pelanggan = $_SESSION['pelanggan'];

// Ambil ID skuter dari parameter URL
$id_skuter = $_GET['id_skuter'];

// Query untuk mendapatkan informasi skuter berdasarkan ID skuter
$query_skuter = "SELECT * FROM skuter WHERE ID_Skuter = $id_skuter";
$result_skuter = mysqli_query($db, $query_skuter);
$skuter = mysqli_fetch_assoc($result_skuter);

// Hitung harga sewa skuter per menit
$harga_per_menit = $skuter['Harga'] / 15;

$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
$error_message = "";
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

include 'header.php';
?>

<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="section-title">
                <h2>Booking</h2>
                <p>Formulir Pemesanan Skuter</p>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <div class="portfolio-wrap">
                        <img src="../uploads/<?php echo $skuter['gambar']; ?>" class="img-fluid" alt="<?php echo $skuter['Merek']; ?>">
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 portfolio-item filter-card">
                    <form action="proses_pesan.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="skuter_id" value="<?php echo $id_skuter; ?>">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="durasi_sewa">Durasi Sewa</label>
                                <select class="form-control" name="durasi_sewa" id="durasi_sewa" required onchange="updateTotal()">
                                    <option>Pilih Waktu</option>
                                    <option value="15">15 Menit</option>
                                    <option value="30">30 Menit</option>
                                    <option value="45">45 Menit</option>
                                    <option value="60">60 Menit</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Harga</label>
                                <input type="text" class="form-control" name="harga" id="harga" value="<?php echo $skuter['Harga']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sewa">Tanggal Sewa</label>
                            <input type="date" class="form-control" name="tanggal_sewa" id="tanggal_sewa" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mulai_jam">Mulai Jam</label>
                            <input type="time" class="form-control" name="mulai_jam" id="mulai_jam" required onchange="updateJamAkhir()">
                        </div>
                        <div class="form-group">
                            <label for="jam_akhir">Jam Akhir</label>
                            <input type="time" class="form-control" name="jam_akhir" id="jam_akhir" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total_bayar">Total Bayar</label>
                            <input type="text" class="form-control" name="total_bayar" id="total_bayar" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bukti_pembayaran">Unggah Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran" required>
                        </div>
                        <input type="hidden" name="status_pembayaran" value="Proses">
                        <button type="submit" class="btn btn-primary">Pesan Skuter</button>
                        <a href="skuter.php" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

<script>
    function updateTotal() {
        var durasi_sewa = document.getElementById("durasi_sewa").value;
        var harga_per_menit = <?php echo $harga_per_menit; ?>;
        var total_bayar = durasi_sewa * harga_per_menit;

        document.getElementById("total_bayar").value = total_bayar;
        
        // Panggil updateJamAkhir() setiap kali durasi_sewa berubah
        updateJamAkhir();
    }

    function updateJamAkhir() {
        var mulai_jam = document.getElementById("mulai_jam").value;
        var durasi_sewa = document.getElementById("durasi_sewa").value;

        if (mulai_jam && durasi_sewa) {
            var mulaiDate = new Date("1970-01-01T" + mulai_jam + "Z");
            var durasiMenit = parseInt(durasi_sewa);
            mulaiDate.setMinutes(mulaiDate.getMinutes() + durasiMenit);

            var jamAkhir = mulaiDate.toISOString().substr(11, 5);
            document.getElementById("jam_akhir").value = jamAkhir;
        } else {
            document.getElementById("jam_akhir").value = '';
        }
    }
</script>

