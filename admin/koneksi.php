<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "keuangan_revisi_1";

$koneksi = new mysqli($servername, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
?>
