<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori_id = $_POST['kategori'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT lk.id, lk.uraian, lk.ref, lk.anggaran, lk.realisasi, lk.selisih, lk.periode
            FROM laporan_keuangan lk
            INNER JOIN laporan_kategori lkat ON lk.id = lkat.laporan_id
            WHERE lkat.kategori_id = ? AND lk.periode BETWEEN ? AND ?";
    
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("iss", $kategori_id, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Laporan Keuangan</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Uraian</th><th>Ref</th><th>Anggaran</th><th>Realisasi</th><th>Selisih</th><th>Periode</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['uraian']}</td>
                        <td>{$row['ref']}</td>
                        <td>{$row['anggaran']}</td>
                        <td>{$row['realisasi']}</td>
                        <td>{$row['selisih']}</td>
                        <td>{$row['periode']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Tidak ada data laporan keuangan untuk kategori dan rentang tanggal yang dipilih.";
        }
    } else {
        echo "Terjadi kesalahan: " . $koneksi->error;
    }
}
?>
