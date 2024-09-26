<?php
session_start();
$title = "Data Sewa | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

include 'header.php';
$success_message = "";
$delete_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['delete_message'])) {
    $delete_message = $_SESSION['delete_message'];
    unset($_SESSION['delete_message']);
}
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span><strong>Data Penyewaan Skuter</strong></span>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
    <a href="sewa.php" class="btn btn-primary col-md-2">Buat Sewa</a>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penyewaan Skuter</h6>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tipe Skuter</th>
                            <th>Durasi Sewa</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tipe Skuter</th>
                            <th>Durasi Sewa</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $query = "SELECT penyewaan.*, pelanggan.Nama AS Nama_Pelanggan, skuter.Tipe AS Tipe_Skuter FROM penyewaan
                        INNER JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.id_pelanggan
                        INNER JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter"; // Query untuk mengambil data penyewaan
                        $result = mysqli_query($db, $query); // Eksekusi query
                        $no = 1; // Nomor urut
                        while ($row = mysqli_fetch_assoc($result)) { // Looping untuk menampilkan data
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td> <!-- Nomor urut -->
                                <td><?php echo $row['Nama_Pelanggan']; ?></td> <!-- Nama Pelanggan -->
                                <td><?php echo $row['Tipe_Skuter']; ?></td> <!-- Tipe Skuter -->
                                <td><?php echo $row['durasi_sewa']; ?> Menit</td> <!-- Durasi Sewa -->
                                <td><?php echo "Rp " . number_format($row['total_bayar'], 2, ',', '.'); ?></td>
                                <td>
                                    <!-- Tombol untuk menghapus data penyewaan -->
                                    <a href="delete_sewa.php?id_penyewaan=<?php echo $row['ID_Penyewaan']; ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
                                    <!-- Tombol untuk mengedit data penyewaan -->
                                    <a href="edit_sewa.php?id_penyewaan=<?php echo $row['ID_Penyewaan']; ?>" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="detail_sewa.php?id_penyewaan=<?php echo $row['ID_Penyewaan']; ?>" class="btn btn-success" title="Edit"><i class="fas fa-info"></i></a>
                                </td> <!-- Total Bayar -->
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
