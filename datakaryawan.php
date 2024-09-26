<?php
session_start();
$title = "Data Karyawan | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

include 'header.php';

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span> <strong>Data Karyawan</strong></span>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <a href="tambahkaryawan.php" class="btn btn-primary col-md-2">Tambah Karyawan +</a>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM admin"; // Query untuk mengambil data dari tabel admin
                        $result = mysqli_query($db, $query); // Eksekusi query
                        while ($row = mysqli_fetch_assoc($result)) { // Looping untuk menampilkan data
                        ?>
                            <tr>
                                <td><?php echo $row['nama']; ?></td> <!-- Menampilkan data nama -->
                                <td><?php echo $row['username']; ?></td> <!-- Menampilkan data username -->
                                <td><?php echo $row['role']; ?></td> <!-- Menampilkan data role -->
                                <td>
                                    <!-- Tombol untuk menghapus data karyawan -->
                                    <a href="delete_karyawan.php?id=<?php echo $row['id_admin']; ?>" class="btn btn-danger" title="Hapus"><i class="fas fa-trash"></i></a>
                                    <!-- Tombol untuk mengedit data karyawan -->
                                    <a href="edit_karyawan.php?id=<?php echo $row['id_admin']; ?>" class="btn btn-warning" title="Edit"><i class="fas fa-info-circle"></i></a>
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