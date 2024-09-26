<?php
session_start();
$title = "Data Pelanggan | Penyewaan Skuter";
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

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span><strong>Data Pelanggan</strong></span>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM pelanggan"; // Query untuk mengambil data dari tabel pelanggan
                        $result = mysqli_query($db, $query); // Eksekusi query
                        $no = 1; // Variabel untuk nomor urut
                        while ($row = mysqli_fetch_assoc($result)) { // Looping untuk menampilkan data
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                                <td><?php echo $row['Nama']; ?></td> <!-- Menampilkan data Nama -->
                                <td><?php echo $row['Username']; ?></td> <!-- Menampilkan data Username -->
                                <td><?php echo $row['alamat']; ?></td> <!-- Menampilkan data Alamat -->
                                <td><?php echo $row['no_telp']; ?></td> <!-- Menampilkan data No. Telepon -->
                                <td>
                                    <a href="delete_pelanggan.php?id=<?php echo $row['id_pelanggan']; ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pelanggan ini?');"><i class="fas fa-trash"></i></a>
                                </td>
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