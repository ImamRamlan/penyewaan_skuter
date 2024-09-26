<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_admin'] = $row['id_admin'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];
        header("location: halaman.php"); // Redirect ke halaman dashboard jika login berhasil
    } else {
        $error = "Username atau password salah";
        header("location: login.php?error=" . urlencode($error)); // Redirect kembali ke halaman login dengan pesan error
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('bg_login.jpg');
            /* Ganti 'background.jpg' dengan path gambar latar belakang yang Anda inginkan */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-container {
            margin-top: 100px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            /* Atur opasitas untuk membantu teks terlihat dengan jelas */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center login-container">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-black">
                        <h5 class="mb-0 text-center">Masuk | Admin</h5>
                    </div>
                    <div class="card-body">
                        <span class="text-muted">
                            <p class="text-center">Masuk Untuk memulai sesi anda.</p>
                        </span>
                        <?php if (isset($_GET['error'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_GET['error']; ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan Username..">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan Kata sandi..">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>