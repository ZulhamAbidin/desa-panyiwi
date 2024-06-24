<?php
include 'src/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../koneksi.php'; 
    $selectedYear = $_POST['year'];
    $data = array(
        'dataMasuk' => getDataByMonth($koneksi, 'masuk', $selectedYear),
        'dataKeluar' => getDataByMonth($koneksi, 'keluar', $selectedYear),
        'dataPenjualan' => getDataByMonth($koneksi, 'penjualan', $selectedYear),
        'dataGaji' => getDataByMonth($koneksi, 'penggajian', $selectedYear),
    );

    echo json_encode($data);
} else {
    header('HTTP/1.1 400 Bad Request');
echo 'Permintaan tidak valid. Tahun tidak ditemukan.';

}
include 'src/footer.php';
?>
