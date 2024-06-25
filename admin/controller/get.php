<?php
include '../koneksi.php';

$searchTerm = isset($_POST['q']) ? $_POST['q'] : '';

$query = "SELECT id, nama_kategori as text FROM kategori WHERE nama_kategori LIKE '%$searchTerm%'";
$result = $koneksi->query($query);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
