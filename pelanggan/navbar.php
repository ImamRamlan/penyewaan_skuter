<!-- navbar -->
<?php 
$pelanggan = $_SESSION['pelanggan'];?>
<nav id="navbar" class="navbar order-last order-lg-0">
    <ul>
        <li>
            <a class="nav-link scrollto" href="dashboard.php">Beranda</a>
        </li>
        <li class="">
            <a class="nav-link scrollto" href="skuter.php">Skuter</a>
        </li>
        <li class="">
            <a class="nav-link scrollto" href="riwayat_sewa.php">Riwayat Sewa</a>
        </li>
      
        <li class="">
            <a class="nav-link scrollto" href="logout_pengguna.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar</a>
        </li>
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->