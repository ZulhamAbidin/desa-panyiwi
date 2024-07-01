<?php
include '../../koneksi.php';

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function formatTanggal($tanggal)
{
    $date = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $date ? $date->format('d-m-Y') : $tanggal;
}

$sql = "SELECT 
            gaji_pegawai.id AS id,
            pegawai.id AS pegawai_id,
            pegawai.nama AS pegawai,
            gaji_pegawai.periode,
            gaji_pegawai.gaji_pokok,
            gaji_pegawai.tunjangan,
            gaji_pegawai.potongan,
            gaji_pegawai.bonus,
            gaji_pegawai.total_gaji,
            gaji_pegawai.tanggal_pembayaran,
            gaji_pegawai.metode_pembayaran
        FROM gaji_pegawai
        JOIN pegawai ON gaji_pegawai.pegawai_id = pegawai.id";

$result = $koneksi->query($sql);

$data = [];
if ($result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $row['No'] = $no;
        $row['gaji_pokok'] = formatRupiah($row['gaji_pokok']);
        $row['tunjangan'] = formatRupiah($row['tunjangan']);
        $row['potongan'] = formatRupiah($row['potongan']);
        $row['bonus'] = formatRupiah($row['bonus']);
        $row['total_gaji'] = formatRupiah($row['total_gaji']);
        $row['tanggal_pembayaran'] = formatTanggal($row['tanggal_pembayaran']);
        $row['aksi'] =
            '
            <button class="btn btn-danger delete-btn" data-id="' .
            $row['id'] .
            '" data-pegawai="' .
            $row['pegawai'] .
            '">Hapus</button>
            <a href="edit_gaji.php?id=' .
            $row['id'] .
            '" class="btn btn-warning edit-btn">Edit</a>
            <a href="histori_gaji.php?pegawai_id=' .
            $row['pegawai_id'] .
            '" class="btn btn-info">Histori dan Slip Gaji</a>';
        $data[] = $row;
        $no++;
    }
}

echo json_encode(['data' => $data]);

$koneksi->close();
?>
