<?php
include '../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $koneksi->begin_transaction();

        $sql_delete_kategori = "DELETE FROM laporan_kategori WHERE laporan_id = ?";
        $stmt_kategori = $koneksi->prepare($sql_delete_kategori);
        $stmt_kategori->bind_param("i", $id);
        $stmt_kategori->execute();

        $sql_delete = "DELETE FROM laporan_keuangan WHERE id = ?";
        $stmt = $koneksi->prepare($sql_delete);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $koneksi->commit();

        echo json_encode(['status' => 'success']);
    } catch (mysqli_sql_exception $e) {
        $koneksi->rollback();

        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan dalam menjalankan query: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>
