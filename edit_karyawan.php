<?php
session_start();
$title = "Edit Karyawan | Penyewaan Skuter";
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

// Tangkap id karyawan yang akan diedit dari parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: datakaryawan.php");
    exit();
}
$id_karyawan = $_GET['id'];

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
        // Lakukan update data ke dalam tabel admin
        $query = "UPDATE admin SET username='$username', password='$password', Nama='$nama', role='$role' WHERE id_admin='$id_karyawan'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['notification'] = "Data karyawan berhasil diperbarui.";
            header("Location: datakaryawan.php");
            exit();
        } else {
            $error_message = "Gagal memperbarui data karyawan: " . mysqli_error($db);
        }
    }
}

// Ambil data karyawan dari database berdasarkan id
$query = "SELECT * FROM admin WHERE id_admin='$id_karyawan'";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 0) {
    header("location: datakaryawan.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Edit Karyawan</h2>
            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="Admin" <?php if ($row['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                        <option value="Karyawan" <?php if ($row['role'] == 'Karyawan') echo 'selected'; ?>>Karyawan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
