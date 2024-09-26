<?php
$db = mysqli_connect("localhost", "root", "", "db_skuter");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>
