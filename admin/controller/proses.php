<?php
include '../../koneksi.php';

if (isset($_POST['tanggal_mulai'], $_POST['tanggal_akhir'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "SELECT p.id, p.nama, p.jabatan, p.periode_pembayaran, MAX(go.gaji_pokok) AS gaji_pokok, MAX(go.tunjangan) AS tunjangan, 
                MAX(go.bonus) AS bonus, MAX(go.potongan) AS potongan,
                MAX(gp.periode) AS tanggal_terakhir_pembayaran
        FROM pegawai p
        LEFT JOIN gaji_otomatis go ON p.id = go.pegawai_id
        LEFT JOIN (
            SELECT pegawai_id, MAX(periode) AS periode FROM gaji_pegawai
            GROUP BY pegawai_id) gp ON p.id = gp.pegawai_id
        GROUP BY p.id, p.nama, p.jabatan, p.periode_pembayaran";

    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $total_gaji_keseluruhan = 0;
    
        while ($row = $result->fetch_assoc()) {
            $total_gaji = 0;
            $periode_terakhir = $row['periode_pembayaran'];
    
            if (!$row['tanggal_terakhir_pembayaran']) {
                $periode_terakhir = 'belum_dibayar';
            }
    
            if ($row['tanggal_terakhir_pembayaran'] && $row['tanggal_terakhir_pembayaran'] >= $tanggal_mulai) {
                switch ($periode_terakhir) {
                    case 'bulanan':
                        $total_gaji = hitungTotalGajiBulanan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                        break;
                    case 'triwulanan':
                        $total_gaji = hitungTotalGajiTriwulanan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                        break;
                    case 'tahunan':
                        $total_gaji = hitungTotalGajiTahunan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
                        break;
                    case 'belum_dibayar':
                        $total_gaji = hitungTotalGajiBulanan($koneksi, $row['id'], $tanggal_mulai, $tanggal_akhir, $row['gaji_pokok']);
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

    $sql = "SELECT MAX(gp.periode) AS tanggal_terakhir_pembayaran
            FROM gaji_pegawai gp
            JOIN pegawai p ON gp.pegawai_id = p.id
            WHERE p.id = ?
            AND p.periode_pembayaran = 'bulanan'
            AND gp.periode <= ?";
    $stmt = $koneksi->prepare($sql);
    $formatted_tanggal_akhir = $tanggal_akhir_obj->format('Y-m-d');
    $stmt->bind_param("is", $pegawai_id, $formatted_tanggal_akhir);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['tanggal_terakhir_pembayaran']) {
        $tanggal_terakhir_pembayaran = new DateTime($row['tanggal_terakhir_pembayaran']);
        $interval = $tanggal_terakhir_pembayaran->diff($tanggal_akhir_obj);
        $total_bulan = $interval->y * 12 + $interval->m;
    } else {
        $interval = $tanggal_mulai_obj->diff($tanggal_akhir_obj);
        $jumlah_bulan = $interval->y * 12 + $interval->m;
        return $gaji_pokok * $jumlah_bulan;
    }

    $jumlah_bulan = $total_bulan;

    return $gaji_pokok * $jumlah_bulan;
}

function hitungTotalGajiTriwulanan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);

    $sql = "SELECT MAX(gp.periode) AS tanggal_terakhir_pembayaran
            FROM gaji_pegawai gp
            JOIN pegawai p ON gp.pegawai_id = p.id
            WHERE p.id = $pegawai_id
            AND p.periode_pembayaran = 'triwulanan'
            AND gp.periode <= '" . $tanggal_akhir_obj->format('Y-m-d') . "'";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
    
    if ($row['tanggal_terakhir_pembayaran']) {
        $tanggal_terakhir_pembayaran = new DateTime($row['tanggal_terakhir_pembayaran']);
        $interval = $tanggal_terakhir_pembayaran->diff($tanggal_akhir_obj);
        $total_bulan = $interval->y * 12 + $interval->m;

        $jumlah_triwulan = floor($total_bulan / 3);

        if ($jumlah_triwulan >= 1) {
            return $gaji_pokok * $jumlah_triwulan;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function hitungTotalGajiTahunan($koneksi, $pegawai_id, $tanggal_mulai, $tanggal_akhir, $gaji_pokok) {
    $tanggal_mulai_obj = new DateTime($tanggal_mulai);
    $tanggal_akhir_obj = new DateTime($tanggal_akhir);
    $formatted_tanggal_akhir = $tanggal_akhir_obj->format('Y-m-d');

    $sql = "SELECT MAX(gp.periode) AS tanggal_terakhir_pembayaran
            FROM gaji_pegawai gp
            JOIN pegawai p ON gp.pegawai_id = p.id
            WHERE p.id = ?
            AND p.periode_pembayaran = 'tahunan'
            AND gp.periode <= ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("is", $pegawai_id, $formatted_tanggal_akhir);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['tanggal_terakhir_pembayaran']) {
        $tanggal_terakhir_pembayaran = new DateTime($row['tanggal_terakhir_pembayaran']);
        $interval = $tanggal_terakhir_pembayaran->diff($tanggal_akhir_obj);
        $total_bulan = $interval->y * 12 + $interval->m;

        $jumlah_tahun = floor($total_bulan / 12);

        if ($jumlah_tahun >= 1) {
            return $gaji_pokok * $jumlah_tahun;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}


$koneksi->close();
?>


<!-- JANGAN KACCAULAH -->