<?php
include '../koneksi.php';

if (isset($_POST['tahun'])) {
    $tahunTerpilih = $_POST['tahun'];

    $query = mysqli_query($koneksi,
        "SELECT 
            SUM(IF(YEAR(periode) = $tahunTerpilih, anggaran, 0)) AS total_anggaran,
            SUM(IF(YEAR(periode) = $tahunTerpilih, realisasi, 0)) AS total_realisasi,
            SUM(IF(YEAR(periode) = $tahunTerpilih, realisasi - anggaran, 0)) AS total_selisih
        FROM laporan_keuangan"
    );

    $dataSummary = mysqli_fetch_array($query);
    $totalAnggaran = $dataSummary['total_anggaran'];
    $totalRealisasi = $dataSummary['total_realisasi'];
    $totalSelisih = $dataSummary['total_selisih'];

    $response = [
        'total_anggaran' => formatRupiah($totalAnggaran),
        'total_realisasi' => formatRupiah($totalRealisasi),
        'total_selisih' => formatRupiah($totalSelisih),
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Tahun parameter is missing']);
}

$koneksi->close();
?>
