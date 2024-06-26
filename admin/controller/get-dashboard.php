<?php
include '../../koneksi.php';

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

$queryTotalKategori = "SELECT COUNT(*) AS total_kategori FROM kategori";
$resultTotalKategori = $koneksi->query($queryTotalKategori);

if ($resultTotalKategori) {
    $dataTotalKategori = $resultTotalKategori->fetch_assoc();
    $totalkategori = $dataTotalKategori['total_kategori'];
} else {
    $totalkategori = 0;
}

$queryTotalDataKeuangan = "SELECT COUNT(*) AS total_data_keuangan FROM laporan_keuangan";
$resultTotalDataKeuangan = $koneksi->query($queryTotalDataKeuangan);

if ($resultTotalDataKeuangan) {
    $dataTotalDataKeuangan = $resultTotalDataKeuangan->fetch_assoc();
    $totaldatakeuangan = $dataTotalDataKeuangan['total_data_keuangan'];
} else {
    $totaldatakeuangan = 0;
}

$queryTotalUserAdmin = "SELECT COUNT(*) AS total_user_admin FROM user";
$resultTotalUserAdmin = $koneksi->query($queryTotalUserAdmin);

if ($resultTotalUserAdmin) {
    $dataTotalUserAdmin = $resultTotalUserAdmin->fetch_assoc();
    $useradmin = $dataTotalUserAdmin['total_user_admin'];
} else {
    $useradmin = 0;
}

$response = [
    'totalkategori' => $totalkategori,
    'totaldatakeuangan' => $totaldatakeuangan,
    'useradmin' => $useradmin,
];

header('Content-Type: application/json');
echo json_encode($response);

$koneksi->close();
?>