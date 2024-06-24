<?php
include '../koneksi.php';

$id_admin = $_POST['id_admin'];

$delete = mysqli_query($koneksi, "DELETE FROM user WHERE id_admin = '$id_admin'");

if ($delete) {
    $response = array(
        'status' => 'success',
        'message' => 'Data berhasil dihapus!'
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Gagal menghapus data. Silakan coba lagi.'
    );
}
echo json_encode($response);
exit();
?>