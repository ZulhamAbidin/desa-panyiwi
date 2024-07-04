<?php
include '../../koneksi.php';

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}

// Query yang benar berdasarkan struktur tabel yang diberikan
$query = "SELECT d.id, p.nama AS nama_pegawai, p.email AS email_pegawai, d.file_path, 
                 DATE(d.created_at) AS tanggal_export, TIME(d.created_at) AS waktu_export
          FROM document d
          JOIN slip_gaji sg ON d.slip_gaji_id = sg.id
          JOIN pegawai p ON sg.pegawai_id = p.id
          ORDER BY d.created_at DESC";

$result = $koneksi->query($query);

if (!$result) {
    die('Query gagal: ' . $koneksi->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        'nama_pegawai' => $row['nama_pegawai'],
        'email_pegawai' => $row['email_pegawai'], // Menambahkan email
        'file_path' => $row['file_path'],
        'tanggal_export' => $row['tanggal_export'],
        'waktu_export' => $row['waktu_export']
    ];
}

header('Content-Type: application/json');
echo json_encode(['data' => $data]);

$koneksi->close();
?>
