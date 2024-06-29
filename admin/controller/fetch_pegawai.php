<?php
include '../../koneksi.php';

$query = "SELECT id, nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran FROM pegawai";

$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    $data = [];
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $actionColumn = '<a href="edit_pegawai.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary" role="button">
                            <i class="fe fe-edit me-1"></i>Edit
                         </a> 
                         <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row['id'] . '" data-nama="' . htmlspecialchars($row['nama'], ENT_QUOTES) . '">
                            <i class="fe fe-trash me-1"></i>Delete
                         </button>';

        $data[] = [
            'No' => $no,
            'Nama' => $row['nama'],
            'Jabatan' => $row['jabatan'],
            'Nomor Identifikasi' => $row['nomor_identifikasi'],
            'Email' => $row['email'],
            'Nomor Telepon' => $row['nomor_telepon'],
            'Alamat' => $row['alamat'],
            'Periode Pembayaran' => $row['periode_pembayaran'],
            'Action' => $actionColumn
        ];
        $no++;
    }

    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['data' => []]);
}

$koneksi->close();
?>