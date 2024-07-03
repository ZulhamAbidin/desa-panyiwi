<?php
include '../../koneksi.php';

if (isset($_POST['tanggal_mulai'], $_POST['tanggal_akhir'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "SELECT p.id, p.nama, p.jabatan, p.periode_pembayaran, MAX(go.gaji_pokok) AS gaji_pokok, MAX(go.tunjangan) AS tunjangan, MAX(go.bonus) AS bonus, MAX(go.potongan) AS potongan,
        MAX(gp.tanggal_pembayaran) AS tanggal_terakhir_pembayaran
        FROM pegawai p
        LEFT JOIN gaji_otomatis go ON p.id = go.pegawai_id
        LEFT JOIN gaji_pegawai gp ON p.id = gp.pegawai_id
        GROUP BY p.id, p.nama, p.jabatan, p.periode_pembayaran";

    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $total_gaji_keseluruhan = 0;

        while ($row = $result->fetch_assoc()) {
            $total_gaji = 0;

            if ($row['tanggal_terakhir_pembayaran'] && $row['tanggal_terakhir_pembayaran'] >= $tanggal_mulai) {
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
    $jumlah_bulan = $interval->y * 12 + $interval->m;
    return $gaji_pokok * $jumlah_bulan;
}


function hitungTotalGajiTriwulanan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);

    // Ambil tanggal terakhir pembayaran gaji pegawai
    $sql = "SELECT MAX(gp.tanggal_pembayaran) AS tanggal_terakhir_pembayaran
            FROM gaji_pegawai gp
            WHERE gp.pegawai_id = $pegawai_id";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
    $tanggal_terakhir_pembayaran = new DateTime($row['tanggal_terakhir_pembayaran']);

    // Hitung selisih bulan dari tanggal terakhir pembayaran hingga tanggal akhir yang dipilih
    $interval = $tanggal_terakhir_pembayaran->diff($tanggal_akhir_obj);
    $total_bulan = $interval->y * 12 + $interval->m;

    // Hitung jumlah triwulan dari tanggal terakhir pembayaran
    $jumlah_triwulan = floor($total_bulan / 3);

    // Jika jumlah triwulan lebih besar atau sama dengan 1, berarti pegawai mendapatkan gaji triwulanan
    if ($jumlah_triwulan >= 1) {
        return $gaji_pokok * $jumlah_triwulan;
    } else {
        return 0; // Jika belum mencapai 3 bulan, gaji triwulanan dihitung nol
    }
}


function hitungTotalGajiTahunan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);
    $interval = $tanggal_mulai_obj->diff($tanggal_akhir_obj);
    $jumlah_tahun = $interval->y;
    return $gaji_pokok * $jumlah_tahun;
}

$koneksi->close();
?>
