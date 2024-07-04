<?php
include '../../koneksi.php';

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Query untuk menghapus data
    $query = "DELETE FROM document WHERE id = ?";
    
    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // Mengembalikan detail kesalahan
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        
        $stmt->close();
    } else {
        // Mengembalikan detail kesalahan
        echo json_encode(['success' => false, 'error' => $koneksi->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID tidak diset']);
}

$koneksi->close();
?>
