<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $forceDelete = isset($_POST['forceDelete']) ? $_POST['forceDelete'] : false;

    try {
        if ($forceDelete) {
             // Hapus data terkait di tabel export_laporan_penggajian
             $sql_delete_export = "DELETE FROM export_laporan_penggajian WHERE pegawai_id = ?";
             $stmt_export = $koneksi->prepare($sql_delete_export);
             $stmt_export->bind_param("i", $id);
             $stmt_export->execute();

             $stmt_export->close(); // Hapus data terkait di tabel export_laporan_penggajian
             $sql_delete_export = "DELETE FROM export_laporan_penggajian WHERE pegawai_id = ?";
             $stmt_export = $koneksi->prepare($sql_delete_export);
             $stmt_export->bind_param("i", $id);
             $stmt_export->execute();
             $stmt_export->close();

            // Hapus data terkait di tabel histori_gaji
            $sql_delete_histori = "DELETE FROM histori_gaji WHERE gaji_pegawai_id IN (SELECT id FROM gaji_pegawai WHERE pegawai_id = ?)";
            $stmt_histori = $koneksi->prepare($sql_delete_histori);
            $stmt_histori->bind_param("i", $id);
            $stmt_histori->execute();
            $stmt_histori->close();

            // Hapus data terkait di tabel slip_gaji
            $sql_delete_slip = "DELETE FROM slip_gaji WHERE gaji_pegawai_id IN (SELECT id FROM gaji_pegawai WHERE pegawai_id = ?)";
            $stmt_slip = $koneksi->prepare($sql_delete_slip);
            $stmt_slip->bind_param("i", $id);
            $stmt_slip->execute();
            $stmt_slip->close();

            // Hapus data di tabel gaji_pegawai
            $sql_delete_gaji = "DELETE FROM gaji_pegawai WHERE pegawai_id = ?";
            $stmt_gaji = $koneksi->prepare($sql_delete_gaji);
            $stmt_gaji->bind_param("i", $id);
            $stmt_gaji->execute();
            $stmt_gaji->close();

            // Hapus data di tabel gaji_otomatis
            $sql_delete_gaji_otomatis = "DELETE FROM gaji_otomatis WHERE pegawai_id = ?";
            $stmt_gaji_otomatis = $koneksi->prepare($sql_delete_gaji_otomatis);
            $stmt_gaji_otomatis->bind_param("i", $id);
            $stmt_gaji_otomatis->execute();
            $stmt_gaji_otomatis->close();

            // Hapus data di tabel pegawai
            $sql_delete_pegawai = "DELETE FROM pegawai WHERE id = ?";
            $stmt_pegawai = $koneksi->prepare($sql_delete_pegawai);
            $stmt_pegawai->bind_param("i", $id);
            $stmt_pegawai->execute();
            $stmt_pegawai->close();

            echo json_encode(['status' => 'success']);
        } else {
            // Cek apakah pegawai memiliki data di tabel gaji
            $sql_check_gaji = "SELECT COUNT(*) AS count FROM gaji_pegawai WHERE pegawai_id = ?";
            $stmt_check = $koneksi->prepare($sql_check_gaji);
            $stmt_check->bind_param("i", $id);
            $stmt_check->execute();
            $result = $stmt_check->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count > 0) {
                echo json_encode(['status' => 'has_gaji_data']);
            } else {
                echo json_encode(['status' => 'no_gaji_data']);
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan dalam menjalankan query: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>