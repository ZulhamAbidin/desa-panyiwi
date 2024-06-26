<?php
include '../../koneksi.php';

$query = "SELECT id, nama_kategori
          FROM kategori";

$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    $data = [];
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $actionColumn = '<a href="kategori_edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary" role="button">
                            <i class="fe fe-edit me-1"></i>Edit
                         </a> 
                         <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row['id'] . '" data-uraian="' . htmlspecialchars($row['nama_kategori'], ENT_QUOTES) . '">
                            <i class="fe fe-trash me-1"></i>Delete
                         </button>';

        $data[] = [
            'No' => $no,
            'nama_kategori' => $row['nama_kategori'],
            'Action' => $actionColumn
        ];
        $no++;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>