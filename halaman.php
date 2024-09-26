<?php
session_start();
$title = "Halaman Utama | Penyewaan Skuter";

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
include 'header.php';

// Koneksi ke database
include 'koneksi.php';

// Ambil jumlah pelanggan
$query_pelanggan = "SELECT COUNT(*) as total_pelanggan FROM pelanggan";
$result_pelanggan = mysqli_query($db, $query_pelanggan);
$row_pelanggan = mysqli_fetch_assoc($result_pelanggan);
$total_pelanggan = $row_pelanggan['total_pelanggan'];

// Ambil total pendapatan dari penyewaan
$query_pendapatan = "SELECT SUM(total_bayar) as total_pendapatan FROM penyewaan";
$result_pendapatan = mysqli_query($db, $query_pendapatan);
$row_pendapatan = mysqli_fetch_assoc($result_pendapatan);
$total_pendapatan = $row_pendapatan['total_pendapatan'];

// Ambil jumlah skuter yang tersedia
$query_skuter = "SELECT COUNT(*) as total_skuter FROM skuter WHERE Status = 'Tersedia'";
$result_skuter = mysqli_query($db, $query_skuter);
$row_skuter = mysqli_fetch_assoc($result_skuter);
$total_skuter = $row_skuter['total_skuter'];

// Ambil jumlah total penyewaan
$query_total_penyewaan = "SELECT COUNT(*) as total_penyewaan FROM penyewaan";
$result_total_penyewaan = mysqli_query($db, $query_total_penyewaan);
$row_total_penyewaan = mysqli_fetch_assoc($result_total_penyewaan);
$total_penyewaan = $row_total_penyewaan['total_penyewaan'];
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span> <strong>Dashboard</strong></span>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Total Pelanggan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pelanggan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_pelanggan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_pendapatan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Skuter Tersedia Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Skuter Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_skuter; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-motorcycle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penyewaan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penyewaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_penyewaan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-lg font-weight-bold mb-1">
                                Selamat Datang, Admin!
                            </div>
                            <div class="text-sm text-gray-800">
                                Anda sedang berada di dashboard sistem penyewaan skuter. Selamat bekerja dan semoga hari Anda menyenangkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>