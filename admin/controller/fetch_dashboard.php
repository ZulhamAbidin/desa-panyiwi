<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if (!$koneksi) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Koneksi database gagal']);
    exit;
}

// Query untuk mendapatkan tahun-tahun yang memiliki data gaji pegawai
$query_years = "SELECT DISTINCT YEAR(gp.periode) AS tahun
               FROM gaji_pegawai gp";

$result_years = $koneksi->query($query_years);

if (!$result_years) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Query tahun gagal: ' . $koneksi->error]);
    exit;
}

$years = [];
while ($row = $result_years->fetch_assoc()) {
    $years[] = $row['tahun'];
}

// Ambil tahun dari parameter GET
$year = isset($_GET['year']) ? intval($_GET['year']) : (count($years) > 0 ? $years[0] : date('Y')); // Default ke tahun pertama jika tidak ada parameter

$query_data = "SELECT pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y') AS periode, SUM(gp.total_gaji) AS total_gaji
              FROM pegawai
              LEFT JOIN gaji_pegawai gp ON pegawai.id = gp.pegawai_id
              WHERE YEAR(gp.periode) = $year
              GROUP BY pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y')";

$result_data = $koneksi->query($query_data);

if (!$result_data) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Query data gagal: ' . $koneksi->error]);
    exit;
}

$data = [
    'period' => [],
    'pegawai' => []
];

while ($row = $result_data->fetch_assoc()) {
    $nama = $row['nama'];
    $periode = $row['periode'];
    $total_gaji = (float) $row['total_gaji'];

    if (!isset($data['pegawai'][$nama])) {
        $data['pegawai'][$nama] = [];
    }

    $data['pegawai'][$nama][$periode] = $total_gaji;

    if (!in_array($periode, $data['period'])) {
        $data['period'][] = $periode;
    }
}

usort($data['period'], function($a, $b) {
    return strtotime($a) - strtotime($b);
});

echo json_encode([
    'years' => $years,
    'data' => $data
]);

$koneksi->close();
?>
