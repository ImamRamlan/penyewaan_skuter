<?php
session_start(); // Mulai sesi

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header("Location: login_pengguna.php");
exit();
?>
