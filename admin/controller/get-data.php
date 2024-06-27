<?php
include '../../koneksi.php';

$query = "SELECT lk.id, lk.uraian, lk.ref, lk.anggaran, lk.realisasi, lk.periode, lk.gambar, lk.deskripsi_gambar, k.nama_kategori
          FROM laporan_keuangan lk
          LEFT JOIN laporan_kategori lktr ON lk.id = lktr.laporan_id
          LEFT JOIN kategori k ON lktr.kategori_id = k.id";

$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    $data = [];
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $selisih = $row['realisasi'] - $row['anggaran'];
        $formattedAnggaran = 'Rp. ' . number_format($row['anggaran'], 0, ',', '.');
        $formattedRealisasi = 'Rp. ' . number_format($row['realisasi'], 0, ',', '.');
        $formattedSelisih = 'Rp. ' . number_format(abs($selisih), 0, ',', '.');
        if ($selisih < 0) {
            $formattedSelisih = '+ ' . $formattedSelisih;
        } else {
            $formattedSelisih = '- ' . $formattedSelisih;
        }

        $actionColumn = '<a href="edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary" role="button">
                            <i class="fe fe-edit me-1"></i>Edit
                         </a> 
                         <button class="mt-2 btn btn-sm btn-danger delete-btn" data-id="' . $row['id'] . '" data-uraian="' . htmlspecialchars($row['uraian'], ENT_QUOTES) . '">
                            <i class="fe fe-trash me-1"></i>Delete
                         </button>';

        $data[] = [
            'No' => $no,
            'Uraian' => $row['uraian'],
            'Ref' => $row['ref'],
            'Anggaran' => $formattedAnggaran,
            'Realisasi' => $formattedRealisasi,
            'Selisih' => $formattedSelisih,
            'Periode' => $row['periode'],
            'Kategori' => $row['nama_kategori'],
            'Gambar' => $row['gambar'],
            'Deskripsi Gambar' => $row['deskripsi_gambar'],
            'Action' => $actionColumn
        ];
        $no++;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>