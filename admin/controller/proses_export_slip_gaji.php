<?php

use Dompdf\Dompdf;
use Dompdf\Options;

require_once '../../vendor/autoload.php';
include '../../koneksi.php';

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception('Invalid request method.');
    }

    $pegawai_id = $_POST['pegawai_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql_pegawai = "SELECT nama FROM pegawai WHERE id = ?";
    $stmt_pegawai = $koneksi->prepare($sql_pegawai);
    $stmt_pegawai->bind_param("i", $pegawai_id);
    $stmt_pegawai->execute();
    $result_pegawai = $stmt_pegawai->get_result();

    if ($result_pegawai->num_rows === 0) {
        throw new Exception('Pegawai dengan ID tersebut tidak ditemukan.');
    }

    $row_pegawai = $result_pegawai->fetch_assoc();
    $nama_pegawai = $row_pegawai['nama'];

    $sql_slip_gaji = "SELECT p.nama AS nama_pegawai, sp.file_path, gp.periode, gp.gaji_pokok, gp.tunjangan, gp.potongan, gp.bonus, gp.total_gaji
        FROM slip_gaji sp
        JOIN gaji_pegawai gp ON sp.gaji_pegawai_id = gp.id
        JOIN pegawai p ON sp.pegawai_id = p.id
        WHERE sp.pegawai_id = ? AND gp.periode BETWEEN ? AND ?";
    $stmt_slip_gaji = $koneksi->prepare($sql_slip_gaji);
    $stmt_slip_gaji->bind_param("iss", $pegawai_id, $start_date, $end_date);
    $stmt_slip_gaji->execute();
    $result_slip_gaji = $stmt_slip_gaji->get_result();

    if ($result_slip_gaji->num_rows === 0) {
        throw new Exception('Tidak ada data slip gaji untuk periode yang dipilih.');
    }

    // Buat instance Dompdf
    $dompdf = new Dompdf();

    // Buat instance Options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    // Terapkan Options ke Dompdf
    $dompdf->setOptions($options);

     // Konten HTML yang akan diubah menjadi PDF
     $html = '<html><head>';
     $html .= '<style>';
     $html .= 'body { font-family: Arial, sans-serif; }';
     $html .= 'h2 { text-align: center; margin-top: 20px; }';
     $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
     $html .= 'th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }'; //
     $html .= 'img { max-width: 200px; height: auto; }';
     $html .= '</style>';
     $html .= '</head><body>';
     $html .= '<h2>Laporan Slip Gaji - ' . htmlspecialchars($nama_pegawai) . '</h2><br>';
     $html .= '<table>
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
 
     while ($row = $result_slip_gaji->fetch_assoc()) {
 
         $image_path = 'C:/laragon/www/keuangan/admin/gambar/' . $row['file_path'];
 
         // Konversi gambar menjadi base64
         $image_data = file_get_contents($image_path);
         $image_base64 = 'data:image/png;base64,' . base64_encode($image_data);
 
         $html .= '<tr>
                     <td>' . htmlspecialchars($row['nama_pegawai']) . '</td>
                     <td>' . htmlspecialchars($row['periode']) . '</td>
                     <td>' . htmlspecialchars($row['gaji_pokok']) . '</td>
                     <td>' . htmlspecialchars($row['tunjangan']) . '</td>
                     <td>' . htmlspecialchars($row['potongan']) . '</td>
                     <td>' . htmlspecialchars($row['bonus']) . '</td>
                     <td>' . htmlspecialchars($row['total_gaji']) . '</td>
                     <td><img src="' . $image_base64 . '" alt="Gambar Slip Gaji"></td>
                 </tr>';
     }
 
     $html .= '</tbody></table>';
     $html .= '</body></html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $file_name = 'slip_gaji_' . str_replace(' ', '_', $nama_pegawai) . '_' . date('YmdHis') . '.pdf';
    $output_file = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/export_pdf/' . $file_name;
    file_put_contents($output_file, $dompdf->output());

    // URL untuk mengunduh file PDF
    $download_url = 'http://' . $_SERVER['HTTP_HOST'] . '/keuangan/admin/export_pdf/' . $file_name;

    echo json_encode(array('status' => 'success', 'url' => $download_url));
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
} finally {
    $stmt_pegawai->close();
    $stmt_slip_gaji->close();
    $koneksi->close();
}
?>
