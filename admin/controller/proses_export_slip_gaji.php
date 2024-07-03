<?php

use Dompdf\Dompdf;

require_once '../../vendor/autoload.php';
include '../../koneksi.php';

// Pastikan ini adalah request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pegawai_id = $_POST['pegawai_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Ambil nama pegawai berdasarkan ID
    $sql_pegawai = "SELECT nama FROM pegawai WHERE id = ?";
    $stmt_pegawai = $koneksi->prepare($sql_pegawai);
    $stmt_pegawai->bind_param("i", $pegawai_id);
    $stmt_pegawai->execute();
    $result_pegawai = $stmt_pegawai->get_result();

    // Jika pegawai ditemukan
    if ($result_pegawai->num_rows > 0) {
        $row_pegawai = $result_pegawai->fetch_assoc();
        $nama_pegawai = $row_pegawai['nama'];

        // Query untuk mendapatkan data slip gaji berdasarkan pegawai dan periode
        $sql_slip_gaji = "SELECT p.nama AS nama_pegawai, sp.file_path, gp.periode, gp.gaji_pokok, gp.tunjangan, gp.potongan, gp.bonus, gp.total_gaji
                        FROM slip_gaji sp
                        JOIN gaji_pegawai gp ON sp.gaji_pegawai_id = gp.id
                        JOIN pegawai p ON sp.pegawai_id = p.id
                        WHERE sp.pegawai_id = ? AND gp.periode BETWEEN ? AND ?";
        $stmt_slip_gaji = $koneksi->prepare($sql_slip_gaji);
        $stmt_slip_gaji->bind_param("iss", $pegawai_id, $start_date, $end_date);
        $stmt_slip_gaji->execute();
        $result_slip_gaji = $stmt_slip_gaji->get_result();

        // Jika data slip gaji ditemukan
        if ($result_slip_gaji->num_rows > 0) {
            $dompdf = new Dompdf();
            $html = '<html><body>';
            $html .= '<h1>Laporan Slip Gaji - ' . $nama_pegawai . '</h1>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Periode</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Potongan</th>
                                <th>Bonus</th>
                                <th>Total Gaji</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>';

            // Memasukkan data slip gaji ke dalam tabel
            while ($row = $result_slip_gaji->fetch_assoc()) {
                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/admin/gambar/' . $row['file_path'];
                $image_url = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/gambar/' . $row['file_path'];
                $html .= '<tr>
                            <td>' . $row['nama_pegawai'] . '</td>
                            <td>' . $row['periode'] . '</td>
                            <td>' . $row['gaji_pokok'] . '</td>
                            <td>' . $row['tunjangan'] . '</td>
                            <td>' . $row['potongan'] . '</td>
                            <td>' . $row['bonus'] . '</td>
                            <td>' . $row['total_gaji'] . '</td>
                            <td><img src="' . $image_url . '" alt="Gambar Slip Gaji" width="100"></td>
                        </tr>';
            }

            $html .= '</tbody></table>';
            $html .= '</body></html>';

            // Menghasilkan PDF menggunakan Dompdf
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Menyimpan file PDF ke server
            $file_name = 'slip_gaji_' . str_replace(' ', '_', $nama_pegawai) . '_' . date('YmdHis') . '.pdf';
            $output_file = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/export_pdf/' . $file_name;
            file_put_contents($output_file, $dompdf->output());

            // Mendapatkan URL untuk file PDF yang disimpan
            $download_url = 'http://' . $_SERVER['HTTP_HOST'] . '/keuangan/admin/export_pdf/' . $file_name;

            // Mengembalikan URL file PDF dalam format JSON
            echo json_encode(array('status' => 'success', 'url' => $download_url));
        } else {
            // Jika tidak ada data slip gaji untuk periode yang dipilih
            echo json_encode(array('status' => 'error', 'message' => 'Tidak ada data slip gaji untuk periode yang dipilih.'));
        }
        
        // Menutup statement dan koneksi database
        $stmt_slip_gaji->close();
    } else {
        // Jika pegawai dengan ID tersebut tidak ditemukan
        echo json_encode(array('status' => 'error', 'message' => 'Pegawai dengan ID tersebut tidak ditemukan.'));
    }

    // Menutup koneksi database
    $stmt_pegawai->close();
    $koneksi->close();
} else {
    // Jika bukan request POST, redirect ke halaman cetak_list_slip_gaji.php
    header("Location: ../cetak_list_slip_gaji.php");
    exit();
}
?>
