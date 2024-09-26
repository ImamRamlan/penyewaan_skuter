<?php
session_start();
$title = "Tambah Karyawan | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Logout user
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Inisialisasi variabel pesan kesalahan
$error_message = "";

// Tangkap data dari formulir jika ada yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password']; // Sesuaikan dengan nama input pada formulir
    $nama = $_POST['nama'];
    $role = $_POST['role'];

    // Validasi data
    if (empty($username) || empty($password) || empty($nama) || empty($role)) {
        $error_message = "Semua field harus diisi.";
    } else {
        // Lakukan penyimpanan data ke dalam tabel admin
        $query = "INSERT INTO admin (username, password, Nama, role) VALUES ('$username', '$password', '$nama', '$role')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['notification'] = "Data karyawan berhasil ditambahkan.";
            header("Location: datakaryawan.php");
            exit();
        } else {
            $error_message = "Gagal menambahkan data karyawan: " . mysqli_error($db);
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Tambah Karyawan</h2>
            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Karyawan">Karyawan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Karyawan</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>