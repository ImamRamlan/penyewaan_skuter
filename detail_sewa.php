<?php
session_start();
$title = "Detail Sewa | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

include 'header.php';

// Periksa apakah parameter ID_Penyewaan diberikan di URL
if (!isset($_GET['id_penyewaan']) || empty($_GET['id_penyewaan'])) {
    // Jika tidak ada, kembali ke halaman data_sewa.php
    header("Location: data_sewa.php");
    exit();
}

// Ambil ID_Penyewaan dari parameter URL
$id_penyewaan = $_GET['id_penyewaan'];

// Query untuk mendapatkan detail penyewaan berdasarkan ID_Penyewaan
$query = "SELECT penyewaan.*, pelanggan.Nama AS Nama_Pelanggan, skuter.Tipe AS Tipe_Skuter FROM penyewaan
            INNER JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.id_pelanggan
            INNER JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter
            WHERE penyewaan.ID_Penyewaan = '$id_penyewaan'";
$result = mysqli_query($db, $query);

// Periksa apakah data ditemukan
if (mysqli_num_rows($result) == 0) {
    // Jika tidak ada data dengan ID_Penyewaan yang diberikan, kembali ke halaman data_sewa.php
    header("Location: data_sewa.php");
    exit();
}

// Ambil data penyewaan
$row = mysqli_fetch_assoc($result);

// Tampilkan detail penyewaan
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Sewa</h1>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Penyewaan Skuter</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td><?php echo $row['Nama_Pelanggan']; ?></td>
                    </tr>
                    <tr>
                        <th>Tipe Skuter</th>
                        <td><?php echo $row['Tipe_Skuter']; ?></td>
                    </tr>
                    <tr>
                        <th>Durasi Sewa</th>
                        <td><?php echo $row['durasi_sewa']; ?> Menit</td>
                    </tr>
                    <tr>
                        <th>Tanggal Sewa</th>
                        <td><?php echo $row['tanggal_sewa']; ?></td>
                    </tr>
                    <tr>
                        <th>Jam Mulai</th>
                        <td><?php echo $row['mulai_jam']; ?></td>
                    </tr>
                    <tr>
                        <th>Jam Akhir</th>
                        <td><?php echo $row['jam_akhir']; ?></td>
                    </tr>
                    <tr>
                        <th>Total Bayar</th>
                        <td>Rp <?php echo number_format($row['total_bayar'], 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td><img src="bukti_pembayaran/<?php echo $row['bukti_pembayaran']; ?>" class="img-fluid" alt=""></td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            <span id="status-pembayaran" class="badge badge-primary" onclick="konfirmasiUbahStatus('<?php echo $row['ID_Penyewaan']; ?>')">
                                <?php echo $row['status_pembayaran']; ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <a href="data_sewa.php" class="btn btn-success">Kembali</a>
</div>
<?php include 'footer.php'; ?>

<script>
    function konfirmasiUbahStatus(idPenyewaan) {
        const statusSekarang = document.getElementById("status-pembayaran").innerText;
        let statusBaru;

        if (statusSekarang === "Sudah Bayar") {
            statusBaru = "Proses";
        } else if (statusSekarang === "Proses") {
            statusBaru = "Belum Bayar";
        } else {
            statusBaru = "Sudah Bayar";
        }

        if (confirm("Apakah Anda yakin ingin mengubah status pembayaran menjadi " + statusBaru + "?")) {
            ubahStatusPembayaran(idPenyewaan, statusBaru);
        }
    }

    function ubahStatusPembayaran(idPenyewaan, statusBaru) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ubah_status_pembayaran.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status === 200 && this.responseText === "Success") {
                document.getElementById("status-pembayaran").innerText = statusBaru;
                document.getElementById("status-pembayaran").className = "badge badge-" + (statusBaru === "Sudah Bayar" ? "success" : (statusBaru === "Proses" ? "warning" : "danger"));
            } else {
                alert("Gagal mengubah status pembayaran.");
            }
        };
        xhr.send("id_penyewaan=" + idPenyewaan + "&status_pembayaran=" + statusBaru);
    }
</script>
