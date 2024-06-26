<?php
include '../../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $sql_delete_kategori = "DELETE FROM kategori WHERE id = ?";
        $stmt_kategori = $koneksi->prepare($sql_delete_kategori);
        $stmt_kategori->bind_param("i", $id);
        $stmt_kategori->execute();

        echo json_encode(['status' => 'success']);
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan dalam menjalankan query: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>