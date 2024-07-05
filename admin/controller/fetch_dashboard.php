<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if (!$koneksi) {
    die(json_encode(['error' => 'Koneksi database gagal']));
}

// Query untuk mendapatkan data gaji per pegawai per periode
$query = "SELECT pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y') AS periode, COUNT(gp.id) AS jumlah_entri, SUM(gp.total_gaji) AS total_gaji
          FROM pegawai
          LEFT JOIN gaji_pegawai gp ON pegawai.id = gp.pegawai_id
          GROUP BY pegawai.nama, DATE_FORMAT(gp.periode, '%M %Y')";


$result = $koneksi->query($query);

if (!$result) {
    die(json_encode(['error' => 'Query gagal: ' . $koneksi->error]));
}

$data = [
    'period' => [],
    'pegawai' => []
];

while ($row = $result->fetch_assoc()) {
    $nama = $row['nama'];
    $periode = $row['periode'];
    $total_gaji = (float) $row['total_gaji']; // Convert to float if necessary
    $jumlah_entri = (int) $row['jumlah_entri']; // Number of entries for this period

    if (!isset($data['pegawai'][$nama])) {
        $data['pegawai'][$nama] = [];
    }
    
    // Set total gaji based on the number of entries (if there are multiple entries)
    $data['pegawai'][$nama][$periode] = $jumlah_entri > 0 ? $total_gaji : 0;

    if (!in_array($periode, $data['period'])) {
        $data['period'][] = $periode;
    }
}

foreach ($data['pegawai'] as &$gaji) {
    foreach ($data['period'] as $p) {
        if (!isset($gaji[$p])) {
            $gaji[$p] = 0;
        }
    }
}

sort($data['period']);

echo json_encode($data);

$koneksi->close();
?>
