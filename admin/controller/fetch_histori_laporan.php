<?php
include '../../koneksi.php';

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}

$query = "SELECT e.id, p.nama AS nama_pegawai, e.file_path,
                 DATE(e.created_at) AS tanggal_export,
                 TIME(e.created_at) AS waktu_export
          FROM export_laporan_penggajian e
          JOIN pegawai p ON e.pegawai_id = p.id
          ORDER BY e.created_at DESC";

$result = $koneksi->query($query);

if (!$result) {
    die('Query gagal: ' . $koneksi->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        'nama_pegawai' => $row['nama_pegawai'],
        'file_path' => $row['file_path'],
        'tanggal_export' => $row['tanggal_export'],
        'waktu_export' => $row['waktu_export']
    ];
}

header('Content-Type: application/json');
echo json_encode(['data' => $data]);

$koneksi->close();
?>