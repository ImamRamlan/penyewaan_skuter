<?php
session_start();
$title = "Tambah Skuter | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Tangkap data dari formulir jika ada yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $merek = $_POST['merek'];
    $tipe = $_POST['tipe'];
    $tahun = $_POST['tahun'];
    $status = $_POST['status'];
    $harga = $_POST['harga']; // Tambahkan untuk menangkap harga
    // Handle upload gambar
    $gambar = 'default.jpeg'; // Gambar default jika tidak diupload

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

        // Mengecek tipe file yang diupload
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array($imageFileType, $allowed_types)) {
            echo "Hanya file gambar dengan format JPG, JPEG, PNG, atau GIF yang diperbolehkan.";
            exit();
        }

        // Pindahkan file yang diupload ke direktori yang ditentukan
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "File berhasil diupload.";
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
            exit();
        }
    }

    // Validasi data (opsional)

    // Lakukan penyimpanan data ke dalam tabel skuter
    $query = "INSERT INTO skuter (Merek, Tipe, Tahun, Status, Harga, gambar) VALUES ('$merek', '$tipe', '$tahun', '$status', '$harga', '$gambar')";
    $result = mysqli_query($db, $query);

    if ($result) {
        $_SESSION['success_message'] = "Data skuter berhasil ditambahkan.";
        header("Location: data_skuter.php"); // Ganti dengan halaman tujuan setelah berhasil tambah data
        exit();
    } else {
        echo "Gagal menambahkan data skuter: " . mysqli_error($db);
        exit();
    }
}
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Tambah Data Skuter</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="merek">Merek:</label>
                    <input type="text" class="form-control" id="merek" name="merek" required>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe:</label>
                    <input type="text" class="form-control" id="tipe" name="tipe" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun:</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Disewa">Disewa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label> <!-- Tambahkan input harga -->
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Data Skuter</button>
                <a href="data_skuter.php" class="btn btn-success">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
