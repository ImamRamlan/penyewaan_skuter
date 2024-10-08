<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query SQL untuk memeriksa apakah username dan password cocok
    $query = "SELECT * FROM pelanggan WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // Jika data ditemukan, simpan data ke dalam session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['pelanggan'] = $row;

        // Redirect ke halaman dashboard atau halaman lain sesuai kebutuhan
        header("location: dashboard.php");
    } else {
        // Jika tidak ditemukan, beri pesan error
        $error = "Username atau password salah!";
    }
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

    <title>Skuter - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-3">Selamat Datang | Penyewaan Skuter</h1>
                                        <small>Masuk untuk memulai sesi anda.</small>
                                        <?php if (!empty($error)) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Masukkan Username Anda." name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="registrasi.php">Buat akun anda !</a>
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