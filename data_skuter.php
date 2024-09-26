<?php
session_start();
$title = "Data Skuter | Penyewaan Skuter";
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
        <span> <strong>Data Skuter</strong></span>
    </div>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <a href="tambah_skuter.php" class="btn btn-primary col-md-2">Tambah Data +</a>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Skuter</h6>
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
                            <th>Merek</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Harga</th> <!-- Tambah kolom harga -->
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Merek</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Harga</th> <!-- Tambah kolom harga -->
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM skuter"; // Query untuk mengambil data dari tabel skuter
                        $result = mysqli_query($db, $query); // Eksekusi query
                        while ($row = mysqli_fetch_assoc($result)) { // Looping untuk menampilkan data
                        ?>
                            <tr>
                                <td><?php echo $row['Merek']; ?></td> <!-- Menampilkan data merek -->
                                <td><?php echo $row['Tipe']; ?></td> <!-- Menampilkan data tipe -->
                                <td><?php echo $row['Tahun']; ?></td> <!-- Menampilkan data tahun -->
                                <td><?php echo $row['Status']; ?></td> <!-- Menampilkan data status -->
                                <td><?php echo $row['Harga']; ?></td> <!-- Menampilkan data harga -->
                                <td><img src="uploads/<?php echo $row['gambar']; ?>" width="100" height="100"></td> <!-- Menampilkan gambar -->
                                <td>
                                    <!-- Tombol untuk menghapus data skuter -->
                                    <a href="delete_skuter.php?id=<?php echo $row['ID_Skuter']; ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
                                    <!-- Tombol untuk mengedit data skuter -->
                                    <a href="edit_skuter.php?id=<?php echo $row['ID_Skuter']; ?>" class="btn btn-warning" title="Edit"><i class="fas fa-info-circle"></i></a>
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
