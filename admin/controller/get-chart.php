<?php
include '../../koneksi.php';

$sql = "SELECT nama_kategori, SUM(anggaran) as total_anggaran, SUM(realisasi) as total_realisasi 
        FROM laporan_keuangan 
        JOIN laporan_kategori ON laporan_keuangan.id = laporan_kategori.laporan_id
        JOIN kategori ON laporan_kategori.kategori_id = kategori.id
        GROUP BY nama_kategori";
$result = $koneksi->query($sql);

$labels = [];
$anggaran = [];
$realisasi = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row["nama_kategori"];
        $anggaran[] = $row["total_anggaran"];
        $realisasi[] = $row["total_realisasi"];
    }
}

$data = [
    'labels' => $labels,
    'anggaran' => $anggaran,
    'realisasi' => $realisasi
];

header('Content-Type: application/json');
echo json_encode($data);

$koneksi->close();
?>