<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $sql_delete_pegawai = "DELETE FROM pegawai WHERE id = ?";
        $stmt_pegawai = $koneksi->prepare($sql_delete_pegawai);
        $stmt_pegawai->bind_param("i", $id);
        $stmt_pegawai->execute();

        echo json_encode(['status' => 'success']);
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan dalam menjalankan query: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>