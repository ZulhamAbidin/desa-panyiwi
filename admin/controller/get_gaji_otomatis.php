<?php
include '../../koneksi.php';

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
    $sql = "SELECT gaji_pokok, tunjangan, bonus, potongan FROM gaji_otomatis WHERE pegawai_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $pegawai_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['gaji_pokok' => 0, 'tunjangan' => 0, 'bonus' => 0, 'potongan' => 0]);
    }
    $stmt->close();
}
$koneksi->close();
?>
