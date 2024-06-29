<?php
include '../../src/header.php';

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

$sql = "SELECT * FROM histori_gaji";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["pegawai_id"] . "</td>
                <td>" . $row["gaji_pegawai_id"] . "</td>
                <td>" . $row["tanggal"] . "</td>
                <td>" . $row["keterangan"] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data found</td></tr>";
}

$koneksi->close();
?>
