<?php
include '../../koneksi.php';

$sql = "SELECT go.id AS gaji_id, p.id AS pegawai_id, p.nama, go.gaji_pokok, go.tunjangan, go.bonus, go.potongan 
        FROM gaji_otomatis go 
        JOIN pegawai p ON go.pegawai_id = p.id";
$result = $koneksi->query($sql);

$data = [];
$no = 1;

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'No' => $no++,
        'Nama' => $row['nama'],
        'Gaji Pokok' => 'Rp ' . number_format($row['gaji_pokok'], 0, ',', '.'),
        'Tunjangan' => 'Rp ' . number_format($row['tunjangan'], 0, ',', '.'),
        'Bonus' => 'Rp ' . number_format($row['bonus'], 0, ',', '.'),
        'Potongan' => 'Rp ' . number_format($row['potongan'], 0, ',', '.'),
        'Action' => '
            <button class="btn btn-danger delete-btn" data-id="' . $row['pegawai_id'] . '" data-nama="' . $row['nama'] . '">Delete</button>
            <a href="edit_settingan.php?id=' . $row['pegawai_id'] . '" class="btn btn-warning">Edit</a>'
    ];
}

$response = [
    "data" => $data
];

echo json_encode($response);

$koneksi->close();
?>
