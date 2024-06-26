<?php
include '../koneksi.php';

if (isset($_POST['year'])) {
    $selectedYear = $_POST['year'];

    $sql = "SELECT k.nama_kategori, 
    SUM(l.anggaran) AS total_anggaran, 
    SUM(l.realisasi) AS total_realisasi,
    SUM(l.realisasi - l.anggaran) AS selisih
    FROM laporan_keuangan l
    JOIN laporan_kategori lk ON l.id = lk.laporan_id
    JOIN kategori k ON lk.kategori_id = k.id
    WHERE YEAR(l.periode) = ?
    GROUP BY k.nama_kategori";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $selectedYear);
    $stmt->execute();
    $result = $stmt->get_result();

    $labels = [];
    $anggaran = [];
    $realisasi = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row["nama_kategori"];
    $anggaran[] = $row["total_anggaran"];
    $realisasi[] = $row["total_realisasi"];
    $selisih[] = $row["selisih"];
}

$data = [
    'labels' => $labels,
    'anggaran' => $anggaran,
    'realisasi' => $realisasi,
    'selisih' => $selisih,
];

    header('Content-Type: application/json');
    echo json_encode($data);

    $stmt->close();
} else {
    echo json_encode(['error' => 'Year parameter is missing']);
}

$koneksi->close();
?>