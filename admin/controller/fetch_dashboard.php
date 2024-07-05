<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if (!$koneksi) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Koneksi database gagal']);
    exit;
}

$query = "SELECT pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y') AS periode, SUM(gp.total_gaji) AS total_gaji
          FROM pegawai
          LEFT JOIN gaji_pegawai gp ON pegawai.id = gp.pegawai_id
          GROUP BY pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y')";

$result = $koneksi->query($query);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Query gagal: ' . $koneksi->error]);
    exit;
}

$data = [
    'period' => [],
    'pegawai' => []
];

while ($row = $result->fetch_assoc()) {
    $nama = $row['nama'];
    $periode = $row['periode'];
    $total_gaji = (float) $row['total_gaji']; // Convert to float if necessary

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

echo json_encode($data);

$koneksi->close();
?>
