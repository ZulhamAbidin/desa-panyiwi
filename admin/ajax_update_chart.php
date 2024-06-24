<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedYear = $_POST["year"];

    $dataMasukBulanan = getDataByMonth($koneksi, 'masuk', $selectedYear);
    $dataKeluarBulanan = getDataByMonth($koneksi, 'keluar', $selectedYear);
    $dataPenjualanBulanan = getDataByMonth($koneksi, 'penjualan', $selectedYear);
    $dataGajiBulanan = getDataByMonth($koneksi, 'penggajian', $selectedYear);

    $totalMasukTahunan = array_sum($dataMasukBulanan);
    $totalKeluarTahunan = array_sum($dataKeluarBulanan);
    $totalPenjualanTahunan = array_sum($dataPenjualanBulanan);
    $totalGajiTahunan = array_sum($dataGajiBulanan);

    $response = [
        'dataMasuk' => $dataMasukBulanan,
        'dataKeluar' => $dataKeluarBulanan,
        'dataPenjualan' => $dataPenjualanBulanan,
        'dataGaji' => $dataGajiBulanan,
        'totalMasukTahunan' => $totalMasukTahunan,
        'totalKeluarTahunan' => $totalKeluarTahunan,
        'totalPenjualanTahunan' => $totalPenjualanTahunan,
        'totalGajiTahunan' => $totalGajiTahunan,
    ];

    echo json_encode($response);
} else {
    echo json_encode([]);
}

function getDataByMonth($koneksi, $jenisData, $tahun) {
    $data = array();

    for ($i = 1; $i <= 12; $i++) {
        $query = null;

        if ($jenisData == 'keluar') { 
            $query = mysqli_query($koneksi, "SELECT sum(jumlah) as Jumlah FROM data_$jenisData WHERE year(tanggal_$jenisData) = '$tahun' AND month(tanggal_$jenisData) = '$i'");
        } elseif ($jenisData == 'masuk') {
            $query = mysqli_query($koneksi, "SELECT sum(jumlah_masuk) as Jumlah FROM data_$jenisData WHERE year(tanggal_$jenisData) = '$tahun' AND month(tanggal_$jenisData) = '$i'");
        } elseif ($jenisData == 'penjualan') {
            $query = mysqli_query($koneksi, "SELECT sum(jumlah_jual) as Jumlah FROM data_$jenisData WHERE year(tanggal_jual) = '$tahun' AND month(tanggal_jual) = '$i'");
        } elseif ($jenisData == 'penggajian') {
            $query = mysqli_query($koneksi, "SELECT sum(banyak_gaji) as Jumlah FROM data_$jenisData WHERE year(tanggal_gaji) = '$tahun' AND month(tanggal_gaji) = '$i'");
        }

        if ($query !== false) {
            $result = mysqli_fetch_array($query);
            $data[] = $result['Jumlah'] ? $result['Jumlah'] : 0;
        } else {
            die(mysqli_error($koneksi));
        }
    }

    return $data;
}
?>
