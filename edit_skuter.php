<?php
session_start();
$title = "Edit Skuter | Penyewaan Skuter";
include 'koneksi.php';

// Cek apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['nama'])) {
    header("location: login.php");
    exit();
}

// Ambil ID Skuter dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: data_skuter.php");
    exit();
}
$id_skuter = $_GET['id'];

// Ambil data skuter dari database
$query = "SELECT * FROM skuter WHERE ID_Skuter = '$id_skuter'";
$result = mysqli_query($db, $query);
$skuter = mysqli_fetch_assoc($result);

// Tangkap data dari formulir jika ada yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $merek = $_POST['merek'];
    $tipe = $_POST['tipe'];
    $tahun = $_POST['tahun'];
    $status = $_POST['status'];
    $harga = $_POST['harga']; // Tambahkan harga

    // Handle upload gambar
    $gambar = $skuter['gambar']; // Tetap gunakan gambar yang sudah ada jika tidak ada gambar baru yang diunggah

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
    $query_update = "UPDATE skuter SET Merek = '$merek', Tipe = '$tipe', Tahun = '$tahun', Status = '$status', Harga = '$harga', gambar = '$gambar' WHERE ID_Skuter = '$id_skuter'";
    $result_update = mysqli_query($db, $query_update);

    if ($result_update) {
        $_SESSION['success_message'] = "Data skuter berhasil diperbarui.";
        header("Location: data_skuter.php"); // Ganti dengan halaman tujuan setelah berhasil perbarui data
        exit();
    } else {
        echo "Gagal memperbarui data skuter: " . mysqli_error($db);
        exit();
    }
}
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Edit Data Skuter</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="merek">Merek:</label>
                    <input type="text" class="form-control" id="merek" name="merek" value="<?php echo $skuter['Merek']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe:</label>
                    <input type="text" class="form-control" id="tipe" name="tipe" value="<?php echo $skuter['Tipe']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun:</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo $skuter['Tahun']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label> <!-- Tambahkan input harga -->
                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $skuter['Harga']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Tersedia" <?php if ($skuter['Status'] == 'Tersedia') echo 'selected'; ?>>Tersedia</option>
                        <option value="Disewa" <?php if ($skuter['Status'] == 'Disewa') echo 'selected'; ?>>Disewa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="data_skuter.php" class="btn btn-success">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
