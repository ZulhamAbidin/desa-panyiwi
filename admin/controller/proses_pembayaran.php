<?php
include '../../koneksi.php';

$pegawaiId = $_POST['pegawai_id'];
$pembayaranYangAkanDatang = $_POST['pembayaran_yang_akan_datang'];
$gajiPokok = $_POST['gaji_pokok'];
$tunjangan = $_POST['tunjangan'];
$potongan = $_POST['potongan'];
$bonus = $_POST['bonus'];
$totalGaji = $_POST['total_gaji'];
$tanggalPembayaran = $_POST['tanggal_pembayaran'];
$metodePembayaran = $_POST['metode_pembayaran'];

if (isset($_FILES['upload_gambar'])) {
    $file_name = $_FILES['upload_gambar']['name'];
    $file_tmp = $_FILES['upload_gambar']['tmp_name'];

    $random_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
    $file_path = '../../admin/gambar/' . $random_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        $sql = "INSERT INTO gaji_pegawai (pegawai_id, periode, gaji_pokok, tunjangan, potongan, bonus, total_gaji, tanggal_pembayaran, metode_pembayaran)
                VALUES ('$pegawaiId', '$pembayaranYangAkanDatang', '$gajiPokok', '$tunjangan', '$potongan', '$bonus', '$totalGaji', '$tanggalPembayaran', '$metodePembayaran')";

        if ($koneksi->query($sql) === TRUE) {
            $lastInsertedId = $koneksi->insert_id;

            $insertSlipGaji = "INSERT INTO slip_gaji (pegawai_id, gaji_pegawai_id, tanggal_dibuat, file_path)
                               VALUES ('$pegawaiId', '$lastInsertedId', CURDATE(), '$random_name')";

            if ($koneksi->query($insertSlipGaji) === TRUE) {
                $response = ['status' => 'success', 'message' => 'Pembayaran berhasil diproses dan informasi slip gaji berhasil disimpan.'];
                echo json_encode($response);
            } else {
                $response = ['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan informasi slip gaji: ' . $koneksi->error];
                echo json_encode($response);
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $koneksi->error];
            echo json_encode($response);
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Gagal mengunggah bukti pembayaran.'];
        echo json_encode($response);
    }
} else {
    $response = ['status' => 'error', 'message' => 'Berkas bukti pembayaran tidak ditemukan.'];
    echo json_encode($response);
}

$koneksi->close();
?>