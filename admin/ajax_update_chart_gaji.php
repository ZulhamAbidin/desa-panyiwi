<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['year'])) {
    $selectedYear = $_POST['year'];

    $query = "
        SELECT pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y') AS periode, SUM(gp.total_gaji) AS total_gaji
        FROM pegawai
        LEFT JOIN gaji_pegawai gp ON pegawai.id = gp.pegawai_id
        WHERE YEAR(gp.periode) = $selectedYear
        GROUP BY pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y')
    ";

    $result = $koneksi->query($query);

    if (!$result) {
        http_response_code(500);
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

    echo json_encode($data);
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid request']);
}

$koneksi->close();
?>
