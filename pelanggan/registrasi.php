<?php
session_start();
require_once '../koneksi.php';

$error = ''; // Inisialisasi variabel error
$success = ''; // Inisialisasi variabel success

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form registrasi
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Query SQL untuk memeriksa apakah username sudah digunakan
    $check_query = "SELECT * FROM pelanggan WHERE Username = ?";
    $check_stmt = mysqli_prepare($db, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Query SQL untuk menyimpan data ke dalam tabel pelanggan
        $query = "INSERT INTO pelanggan (Nama, Username, Password, alamat, no_telp) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $password, $alamat, $no_telp);

        // Lakukan eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika data berhasil disimpan, arahkan pengguna ke halaman login
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            // Jika terjadi kesalahan, simpan pesan error
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    }

    // Tutup statement untuk pemeriksaan username
    mysqli_stmt_close($check_stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pengguna | Daftar Akun</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-3">Create an Account!</h1>
                                        <?php if (!empty($error)) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($success)) : ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $success; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="inputNama" placeholder="Nama" name="nama">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="inputUsername" placeholder="Username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="inputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="inputAlamat" placeholder="Alamat" name="alamat">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="inputNoTelp" placeholder="Nomor Telepon" name="no_telp">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login_pengguna.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>