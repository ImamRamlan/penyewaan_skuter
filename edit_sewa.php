<?php
session_start();
$title = "Edit Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Ambil ID Penyewaan dari parameter URL
$id_penyewaan = $_GET['id_penyewaan'];

// Query untuk mendapatkan data penyewaan berdasarkan ID
$query_penyewaan = "SELECT penyewaan.*, pelanggan.Nama AS Nama_Pelanggan, skuter.Tipe AS Tipe_Skuter, skuter.Harga AS Harga_Skuter 
                    FROM penyewaan
                    INNER JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.id_pelanggan
                    INNER JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter
                    WHERE penyewaan.ID_Penyewaan = $id_penyewaan";
$result_penyewaan = mysqli_query($db, $query_penyewaan);
$row_penyewaan = mysqli_fetch_assoc($result_penyewaan);

// Mendapatkan data pelanggan dari database
$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = mysqli_query($db, $query_pelanggan);

// Mendapatkan data skuter dari database
$query_skuter = "SELECT * FROM skuter";
$result_skuter = mysqli_query($db, $query_skuter);

// Proses penyimpanan perubahan penyewaan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_skuter = $_POST['id_skuter'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $mulai_jam = $_POST['mulai_jam'];
    $durasi_sewa = $_POST['durasi_sewa'];
    $jam_akhir = $_POST['jam_akhir'];
    $old_bukti_pembayaran = $_POST['old_bukti_pembayaran'];
    $new_bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];

    // Jika ada bukti pembayaran baru, upload dan hapus bukti pembayaran lama
    if (!empty($new_bukti_pembayaran)) {
        // Upload file bukti pembayaran baru
        $target_dir = "bukti_pembayaran/";
        $target_file = $target_dir . basename($new_bukti_pembayaran);
        move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file);

        // Hapus bukti pembayaran lama
        if (!empty($old_bukti_pembayaran)) {
            unlink("bukti_pembayaran/" . $old_bukti_pembayaran);
        }
    } else {
        // Jika tidak ada bukti pembayaran baru, gunakan bukti pembayaran lama
        $target_file = $old_bukti_pembayaran;
    }

    // Update data penyewaan ke dalam tabel penyewaan
    $query_update = "UPDATE penyewaan 
                     SET ID_Pelanggan = '$id_pelanggan', ID_Skuter = '$id_skuter', 
                         tanggal_sewa = '$tanggal_sewa', mulai_jam = '$mulai_jam', 
                         durasi_sewa = '$durasi_sewa', jam_akhir = '$jam_akhir', 
                         bukti_pembayaran = '$target_file'
                     WHERE ID_Penyewaan = '$id_penyewaan'";
    $result_update = mysqli_query($db, $query_update);

    if ($result_update) {
        $_SESSION['success_message'] = "Perubahan penyewaan berhasil disimpan.";
        header("Location: data_sewa.php"); // Redirect kembali ke halaman data penyewaan
        exit();
    } else {
        echo "Gagal menyimpan perubahan penyewaan: " . mysqli_error($db);
        exit();
    }
}
include 'header.php';
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Penyewaan Skuter</h1>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Penyewaan</h6>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_pelanggan">Pilih Pelanggan:</label>
                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php while ($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)) : ?>
                            <option value="<?php echo $row_pelanggan['id_pelanggan']; ?>" <?php if ($row_pelanggan['id_pelanggan'] == $row_penyewaan['ID_Pelanggan']) echo 'selected="selected"'; ?>><?php echo $row_pelanggan['Nama']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_skuter">Pilih Skuter:</label>
                    <select class="form-control" id="id_skuter" name="id_skuter" required>
                        <option value="">Pilih Skuter</option>
                        <?php while ($row_skuter = mysqli_fetch_assoc($result_skuter)) : ?>
                            <option value="<?php echo $row_skuter['ID_Skuter']; ?>" <?php if ($row_skuter['ID_Skuter'] == $row_penyewaan['ID_Skuter']) echo 'selected="selected"'; ?>><?php echo $row_skuter['Tipe']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_sewa">Tanggal Sewa:</label>
                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="<?php echo $row_penyewaan['tanggal_sewa']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mulai_jam">Mulai Jam:</label>
                    <input type="time" class="form-control" id="mulai_jam" name="mulai_jam" value="<?php echo $row_penyewaan['mulai_jam']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jam_akhir">Jam Akhir:</label>
                    <input type="time" class="form-control" id="jam_akhir" name="jam_akhir" value="<?php echo $row_penyewaan['jam_akhir']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="durasi_sewa">Durasi Sewa (per 15 menit)</label>
                    <select name="durasi_sewa" id="durasi_sewa" class="form-control" required>
                        <option value="">Pilih Waktu</option>
                        <option value="15" <?php if ($row_penyewaan['durasi_sewa'] == 15) echo 'selected="selected"'; ?>>15 Menit</option>
                        <option value="30" <?php if ($row_penyewaan['durasi_sewa'] == 30) echo 'selected="selected"'; ?>>30 Menit</option>
                        <option value="45" <?php if ($row_penyewaan['durasi_sewa'] == 45) echo 'selected="selected"'; ?>>45 Menit</option>
                        <option value="60" <?php if ($row_penyewaan['durasi_sewa'] == 60) echo 'selected="selected"'; ?>>60 Menit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bukti_pembayaran">Bukti Pembayaran:</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran">
                    <input type="hidden" name="old_bukti_pembayaran" value="<?php echo $row_penyewaan['bukti_pembayaran']; ?>">
                </div>
                <div class="form-group">
                    <label for="total_bayar">Total Bayar:</label>
                    <input type="text" class="form-control" id="total_bayar" name="total_bayar" value="<?php echo $row_penyewaan['total_bayar']; ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

        // Hitung total bayar
        var hargaSkuter = <?php echo $row_penyewaan['Harga_Skuter']; ?>;
        var durasiSewa = document.getElementById('durasi_sewa').value;
        var totalBayar = hargaSkuter * durasiSewa / 15; // Harga per 15 menit
        document.getElementById('total_bayar').value = totalBayar.toFixed(2);
    }
</script>