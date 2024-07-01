<?php
include '../../koneksi.php';

// Mengambil data dari POST request
$pegawaiId = $_POST['pegawai_id'];
$pembayaranYangAkanDatang = $_POST['pembayaran_yang_akan_datang'];
$gajiPokok = $_POST['gaji_pokok'];
$tunjangan = $_POST['tunjangan'];
$potongan = $_POST['potongan'];
$bonus = $_POST['bonus'];
$totalGaji = $_POST['total_gaji'];
$tanggalPembayaran = $_POST['tanggal_pembayaran'];
$metodePembayaran = $_POST['metode_pembayaran'];

// Simpan data pembayaran ke dalam database
$sql = "INSERT INTO gaji_pegawai (pegawai_id, periode, gaji_pokok, tunjangan, potongan, bonus, total_gaji, tanggal_pembayaran, metode_pembayaran)
        VALUES ('$pegawaiId', '$pembayaranYangAkanDatang', '$gajiPokok', '$tunjangan', '$potongan', '$bonus', '$totalGaji', '$tanggalPembayaran', '$metodePembayaran')";

if ($koneksi->query($sql) === TRUE) {
    $response = ['status' => 'success', 'message' => 'Pembayaran berhasil diproses.'];
    echo json_encode($response);
} else {
    $response = ['status' => 'error', 'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $koneksi->error];
    echo json_encode($response);
}

$koneksi->close();
?>
