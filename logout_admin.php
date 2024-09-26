<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: login.php");
exit;
?>