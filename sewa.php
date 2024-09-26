<?php
session_start();
$title = "Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Mendapatkan data pelanggan dari database
$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = mysqli_query($db, $query_pelanggan);

// Mendapatkan data skuter dari database
$query_skuter = "SELECT * FROM skuter";
$result_skuter = mysqli_query($db, $query_skuter);

// Inisialisasi variabel untuk pesan kesuksesan dan pesan penghapusan
$success_message = "";
$delete_message = "";

// Proses penyewaan skuter
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_skuter = $_POST['id_skuter'];
    $durasi_sewa = $_POST['durasi_sewa'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $mulai_jam = $_POST['mulai_jam'];
    $jam_akhir = $_POST['jam_akhir'];
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];

    // Upload file bukti pembayaran
    $target_dir = "bukti_pembayaran/";
    $target_file = $target_dir . basename($bukti_pembayaran);
    move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file);

    // Hitung total bayar
    $query_harga = "SELECT Harga FROM skuter WHERE ID_Skuter = '$id_skuter'";
    $result_harga = mysqli_query($db, $query_harga);
    $row_harga = mysqli_fetch_assoc($result_harga);
    $harga_per_15_menit = $row_harga['Harga'] / 15; // Harga per 15 menit
    $total_bayar = $durasi_sewa * $harga_per_15_menit;

    // Simpan data penyewaan ke dalam tabel penyewaan
    $query_simpan = "INSERT INTO penyewaan (ID_Pelanggan, ID_Skuter, durasi_sewa, total_bayar, tanggal_sewa, mulai_jam, jam_akhir, bukti_pembayaran) VALUES ('$id_pelanggan', '$id_skuter', '$durasi_sewa', '$total_bayar', '$tanggal_sewa', '$mulai_jam', '$jam_akhir', '$bukti_pembayaran')";
    $result_simpan = mysqli_query($db, $query_simpan);

    if ($result_simpan) {
        $_SESSION['success_message'] = "Penyewaan berhasil dibuat.";
        header("Location: data_sewa.php"); // Redirect kembali ke halaman penyewaan
        exit();
    } else {
        echo "Gagal membuat penyewaan: " . mysqli_error($db);
        exit();
    }
}
include 'header.php';
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penyewaan Skuter</h1>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat Sewa</h6>
            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($delete_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $delete_message; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_pelanggan">Pilih Pelanggan:</label>
                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php while ($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)) : ?>
                            <option value="<?php echo $row_pelanggan['id_pelanggan']; ?>"><?php echo $row_pelanggan['Nama']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_skuter">Pilih Skuter:</label>
                    <select class="form-control" id="id_skuter" name="id_skuter" required>
                        <option value="">Pilih Skuter</option>
                        <?php while ($row_skuter = mysqli_fetch_assoc($result_skuter)) : ?>
                            <option value="<?php echo $row_skuter['ID_Skuter']; ?>"><?php echo $row_skuter['Tipe']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_sewa">Tanggal Sewa:</label>
                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                </div>
                <div class="form-group">
                    <label for="mulai_jam">Mulai Jam:</label>
                    <input type="time" class="form-control" id="mulai_jam" name="mulai_jam" required>
                </div>
                <div class="form-group">
                    <label for="jam_akhir">Jam Akhir:</label>
                    <input type="time" class="form-control" id="jam_akhir" name="jam_akhir" readonly>
                </div>
                <div class="form-group">
                    <label for="durasi_sewa">Durasi Sewa (per 15 menit)</label>
                    <select name="durasi_sewa" id="durasi_sewa" class="form-control" required>
                        <option value="">Pilih Waktu</option>
                        <option value="15">15 Menit</option>
                        <option value="30">30 Menit</option>
                        <option value="45">45 Menit</option>
                        <option value="60">60 Menit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bukti_pembayaran">Bukti Pembayaran:</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                </div>
                <button type="submit" class="btn btn-primary">Buat Sewa</button>
                <a href="data_sewa.php" class="btn btn-warning">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script>
    document.getElementById('durasi_sewa').addEventListener('change', updateJamAkhir);
    document.getElementById('mulai_jam').addEventListener('change', updateJamAkhir);

    function updateJamAkhir() {
        var mulaiJam = document.getElementById('mulai_jam').value;
        var durasiSewa = document.getElementById('durasi_sewa').value;

        if (mulaiJam && durasiSewa) {
            var mulaiDate = new Date("1970-01-01T" + mulaiJam + "Z");
            var durasiMenit = parseInt(durasiSewa);
            mulaiDate.setMinutes(mulaiDate.getMinutes() + durasiMenit);

            var jamAkhir = mulaiDate.toISOString().substr(11, 5);
            document.getElementById('jam_akhir').value = jamAkhir;
        } else {
            document.getElementById('jam_akhir').value = '';
        }
    }
</script>
