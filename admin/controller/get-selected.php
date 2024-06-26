<?php
include '../../koneksi.php';

$query = "
    SELECT lk.id, lk.uraian, lk.ref, lk.anggaran, lk.realisasi, lk.periode, k.nama_kategori 
    FROM laporan_keuangan lk
    LEFT JOIN laporan_kategori lkat ON lk.id = lkat.laporan_id
    LEFT JOIN kategori k ON lkat.kategori_id = k.id
";
$result = $koneksi->query($query);

if ($result === false) {
    echo json_encode(array("status" => "error", "message" => "Query error: " . $koneksi->error));
    exit();
}

$data = array();
while ($row = $result->fetch_assoc()) {
    $selisih = $row['anggaran'] - $row['realisasi'];
    $row['selisih'] = ($selisih < 0 ? '-' : '+') . abs($selisih);
    $data[] = $row;
}

echo json_encode(array("status" => "success", "data" => $data));
exit();
?>
