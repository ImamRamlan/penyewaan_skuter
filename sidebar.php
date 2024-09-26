<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bicycle"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Penyewaan <sup>Skuter</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'halaman.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="halaman.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MAIN FEATURES
    </div>

    <!-- Nav Item - Data Karyawan -->
    
    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'datakaryawan.php' || basename($_SERVER['PHP_SELF']) == 'tambahkaryawan.php' || basename($_SERVER['PHP_SELF']) == 'edit_karyawan.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="datakaryawan.php">
            <i class="nav-icon fas fa-user"></i>
            <span>Data Karyawan</span></a>
    </li>

    <!-- Nav Item - Data Skuter -->
    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'data_skuter.php' || basename($_SERVER['PHP_SELF']) == 'tambah_skuter.php' || basename($_SERVER['PHP_SELF']) == 'edit_skuter.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="data_skuter.php">
            <i class="fas fa-bicycle"></i>
            <span>Data Skuter</span></a>
    </li>
    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'data_pelanggan.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="data_pelanggan.php">
            <i class="fas fa-bicycle"></i>
            <span>Data Pelanggan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MAIN MORE.
    </div>

    <!-- Nav Item - Pembayaran -->
    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'data_sewa.php' || basename($_SERVER['PHP_SELF']) == 'sewa.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="data_sewa.php">
            <i class="fas fa-store"></i>
            <span>Sewa</span></a>
    </li>
    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'laporan_perhari.php' || basename($_SERVER['PHP_SELF']) == 'laporan_perhari.php' ? 'active' : ''; ?>">
        <a class="nav-link" href="laporan_perhari.php">
            <i class="fas fa-store"></i>
            <span>Laporan Perhari</span></a>
    </li>
    <!-- Nav Item - Keluar -->
    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'logout_admin.php' ? 'active' : ''; ?>">
        <a href="logout_admin.php" class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            Keluar
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>