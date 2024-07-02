<?php
include '../../koneksi.php';

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function formatTanggal($tanggal)
{
    $date = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$date) return $tanggal;

    $bulanIndonesia = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $hari = $date->format('d');
    $bulan = $bulanIndonesia[(int)$date->format('m')];
    $tahun = $date->format('Y');

    return "{$hari} {$bulan} {$tahun}";
}

function formatTanggalPeriode($tanggal, $periodePembayaran)
{
    $date = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$date) return $tanggal;

    $bulanIndonesia = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $hari = $date->format('d');
    $bulan = $bulanIndonesia[(int)$date->format('m')];
    $tahun = $date->format('Y');

    $endDate = clone $date;
    if ($periodePembayaran === 'bulanan') {
        $endDate->modify('+1 month');
    } elseif ($periodePembayaran === 'triwulanan') {
        $endDate->modify('+3 months');
    } elseif ($periodePembayaran === 'tahunan') {
        $endDate->modify('+1 year');
    }

    $endHari = $endDate->format('d');
    $endBulan = $bulanIndonesia[(int)$endDate->format('m')];
    $endTahun = $endDate->format('Y');

    return "{$hari} {$bulan} {$tahun} Sampai Dengan {$endHari} {$endBulan} {$endTahun}";
}

$pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : 0;

$sqlPegawai = "SELECT nama FROM pegawai WHERE id = ?";
$stmtPegawai = $koneksi->prepare($sqlPegawai);
$stmtPegawai->bind_param('i', $pegawai_id);
$stmtPegawai->execute();
$resultPegawai = $stmtPegawai->get_result();
$pegawai = $resultPegawai->fetch_assoc();
$namaPegawai = $pegawai['nama'];

$sql = "SELECT 
            gaji_pegawai.id AS id,
            gaji_pegawai.periode,
            gaji_pegawai.gaji_pokok,
            gaji_pegawai.tunjangan,
            gaji_pegawai.potongan,
            gaji_pegawai.bonus,
            gaji_pegawai.total_gaji,
            gaji_pegawai.tanggal_pembayaran,
            gaji_pegawai.metode_pembayaran,
            pegawai.periode_pembayaran,
            slip_gaji.file_path
        FROM gaji_pegawai
        JOIN pegawai ON gaji_pegawai.pegawai_id = pegawai.id
        LEFT JOIN slip_gaji ON gaji_pegawai.id = slip_gaji.gaji_pegawai_id
        WHERE gaji_pegawai.pegawai_id = ?
        ORDER BY gaji_pegawai.id DESC"; ;

$stmt = $koneksi->prepare($sql);
$stmt->bind_param('i', $pegawai_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $row['No'] = $no;
        $row['periode_pembayaran'] = formatTanggalPeriode($row['periode'], $row['periode_pembayaran']);
        $row['gaji_pokok'] = formatRupiah($row['gaji_pokok']);
        $row['tunjangan'] = formatRupiah($row['tunjangan']);
        $row['potongan'] = formatRupiah($row['potongan']);
        $row['bonus'] = formatRupiah($row['bonus']);
        $row['total_gaji'] = formatRupiah($row['total_gaji']);
        $row['tanggal_pembayaran'] = formatTanggal($row['tanggal_pembayaran'], $row['tanggal_pembayaran']);
        $data[] = $row;
        $no++;
    }
}

echo json_encode(['data' => $data, 'namaPegawai' => $namaPegawai]);

$stmt->close();
$koneksi->close();
?>
