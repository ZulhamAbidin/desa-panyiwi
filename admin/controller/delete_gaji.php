<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Hapus data dari tabel slip_gaji
        $sql_slip = "DELETE FROM slip_gaji WHERE gaji_pegawai_id = ?";
        $stmt_slip = $koneksi->prepare($sql_slip);
        $stmt_slip->bind_param("i", $id);
        if (!$stmt_slip->execute()) {
            throw new Exception("Gagal menghapus slip gaji: " . $stmt_slip->error);
        }

        // Hapus data dari tabel histori_gaji
        $sql_histori = "DELETE FROM histori_gaji WHERE gaji_pegawai_id = ?";
        $stmt_histori = $koneksi->prepare($sql_histori);
        $stmt_histori->bind_param("i", $id);
        if (!$stmt_histori->execute()) {
            throw new Exception("Gagal menghapus histori gaji: " . $stmt_histori->error);
        }

        // Hapus data dari tabel gaji_pegawai
        $sql_gaji = "DELETE FROM gaji_pegawai WHERE id = ?";
        $stmt_gaji = $koneksi->prepare($sql_gaji);
        $stmt_gaji->bind_param("i", $id);
        if (!$stmt_gaji->execute()) {
            throw new Exception("Gagal menghapus gaji pegawai: " . $stmt_gaji->error);
        }

        // Komit transaksi
        $koneksi->commit();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $koneksi->rollback();

        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $stmt_slip->close();
    $stmt_histori->close();
    $stmt_gaji->close();
}

$koneksi->close();
?>
