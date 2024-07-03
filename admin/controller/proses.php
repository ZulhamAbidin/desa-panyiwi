<?php
include '../../koneksi.php';

if (isset($_POST['tanggal_mulai'], $_POST['tanggal_akhir'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "SELECT p.id, p.nama, p.jabatan, p.periode_pembayaran, go.gaji_pokok, go.tunjangan, go.bonus, go.potongan
            FROM pegawai p
            LEFT JOIN gaji_otomatis go ON p.id = go.pegawai_id";

    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $total_gaji_keseluruhan = 0;

        while ($row = $result->fetch_assoc()) {
            $total_gaji = 0;

            switch ($row['periode_pembayaran']) {
                case 'bulanan':
                    $total_gaji = hitungTotalGajiBulanan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                    break;
                case 'triwulanan':
                    $total_gaji = hitungTotalGajiTriwulanan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                    break;
                case 'tahunan':
                    $total_gaji = hitungTotalGajiTahunan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                    break;
                default:
                    $total_gaji = 0;
                    break;
            }

            echo "{$row['nama']}: Rp " . number_format($total_gaji, 0, ',', '.') . "<br>";
            $total_gaji_keseluruhan += $total_gaji;
        }

        echo "Total Gaji Keseluruhan: Rp " . number_format($total_gaji_keseluruhan, 0, ',', '.');
    } else {
        echo "Tidak ada data pegawai.";
    }
} else {
    echo "Tanggal mulai dan tanggal akhir tidak ditemukan dalam data POST.";
}

function hitungTotalGajiBulanan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);
    $interval = $tanggal_mulai_obj->diff($tanggal_akhir_obj);
    $jumlah_bulan = $interval->y * 12 + $interval->m; // Total bulan dari selisih tahun dan bulan
    return $gaji_pokok * $jumlah_bulan;
}

function hitungTotalGajiTriwulanan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);
    $interval = $tanggal_mulai_obj->diff($tanggal_akhir_obj);
    $jumlah_setiap_3_bulan = ceil($interval->m / 3);  // Jumlah triwulan dari selisih bulan
    return $gaji_pokok * $jumlah_setiap_3_bulan;
}

function hitungTotalGajiTahunan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);
    $interval = $tanggal_mulai_obj->diff($tanggal_akhir_obj);
    $jumlah_tahun = $interval->y; // Total tahun dari selisih tahun
    return $gaji_pokok * $jumlah_tahun;
}

$koneksi->close();
?>
