<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = isset($_POST['id']) ? $_POST['id'] : '';

    if (!empty($pegawai_id)) {
        $sql = "DELETE FROM gaji_otomatis WHERE pegawai_id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $pegawai_id); // Jika pegawai_id adalah string, ganti "i" menjadi "s"

        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ];
        }

        $stmt->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'ID tidak ditemukan.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Permintaan tidak valid.'
    ];
}

$koneksi->close();
echo json_encode($response);
?>
