<?php
session_start();
$title = "Laporan Penyewaan Per Hari | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Logout user
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}
include 'header.php';

// Set tanggal_mulai dan tanggal_akhir default jika tidak ada data POST
$tanggal_mulai = isset($_POST['tanggal_mulai']) ? $_POST['tanggal_mulai'] : date('Y-m-d');
$tanggal_akhir = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : date('Y-m-d');

// Ambil data penyewaan berdasarkan rentang tanggal
$query = "SELECT penyewaan.*, pelanggan.Nama AS nama_pelanggan, skuter.Merek AS merek_skuter 
          FROM penyewaan 
          INNER JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.id_pelanggan
          INNER JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter
          WHERE tanggal_sewa BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
$result = mysqli_query($db, $query);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span><strong>Laporan Penyewaan Per Hari</strong></span>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Penyewaan Per Hari</h6>
        </div>
        <div class="card-body">
            <form action="laporan_perhari.php" method="POST">
                <div class="form-group row">
                    <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo htmlspecialchars($tanggal_mulai); ?>">
                    </div>
                    <label for="tanggal_akhir" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo htmlspecialchars($tanggal_akhir); ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Merek Skuter</th>
                            <th>Durasi Sewa</th>
                            <th>Tanggal Sewa</th>
                            <th>Mulai Jam</th>
                            <th>Total Bayar</th>
                            <th>Jam Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($no); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                            <td><?php echo htmlspecialchars($row['merek_skuter']); ?></td>
                            <td><?php echo htmlspecialchars($row['durasi_sewa']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_sewa']); ?></td>
                            <td><?php echo htmlspecialchars($row['mulai_jam']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_bayar']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam_akhir']); ?></td>
                        </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
