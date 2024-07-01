<?php
include '../../koneksi.php';

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function getNextPaymentDate($lastPaymentDate, $period)
{
    $date = new DateTime($lastPaymentDate);
    switch ($period) {
        case 'bulanan':
            $date->modify('+1 month');
            break;
        case 'triwulanan':
            $date->modify('+3 months');
            break;
        case 'tahunan':
            $date->modify('+1 year');
            break;
    }
    return $date->format('Y-m-d');
}

$sql = "SELECT p.id AS pegawai_id, p.nama, p.jabatan, p.nomor_telepon, p.periode_pembayaran, p.nomor_identifikasi,
               MAX(go.gaji_pokok) AS gaji_pokok, MAX(go.tunjangan) AS tunjangan, 
               MAX(go.bonus) AS bonus, MAX(go.potongan) AS potongan, MAX(gp.periode) AS last_payment_date
        FROM pegawai p
        JOIN gaji_otomatis go ON p.id = go.pegawai_id
        JOIN gaji_pegawai gp ON p.id = gp.pegawai_id
        GROUP BY p.id, p.nama, p.jabatan, p.nomor_telepon, p.periode_pembayaran, p.nomor_identifikasi";

$result = $koneksi->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $next_payment_date = getNextPaymentDate($row['last_payment_date'], $row['periode_pembayaran']);
    $total_gaji = $row['gaji_pokok'] + $row['tunjangan'] + $row['bonus'] - $row['potongan'];
    $data[] = [
        'pegawai_id' => $row['pegawai_id'],
        'nama' => $row['nama'],
        'jabatan' => $row['jabatan'],
        'nomor_telepon' => $row['nomor_telepon'],
        'periode_pembayaran' => $row['periode_pembayaran'],
        'nomor_identifikasi' => $row['nomor_identifikasi'],
        'gaji_pokok' => formatRupiah($row['gaji_pokok']),
        'tunjangan' => formatRupiah($row['tunjangan']),
        'bonus' => formatRupiah($row['bonus']),
        'potongan' => formatRupiah($row['potongan']),
        'total_gaji' => formatRupiah($total_gaji),
        'tanggal_pembayaran' => $row['last_payment_date'],
        'pembayaran_yang_akan_datang' => $next_payment_date
    ];
}

header('Content-Type: application/json');
echo json_encode(['data' => $data]);

$koneksi->close();
?>
