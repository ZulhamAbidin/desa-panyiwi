<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../vendor/autoload.php';
include '../../koneksi.php';

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception('Invalid request method.');
    }

    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }    

    $pegawai_id = $_POST['pegawai_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql_pegawai = "SELECT nama, email FROM pegawai WHERE id = ?";
    $stmt_pegawai = $koneksi->prepare($sql_pegawai);
    $stmt_pegawai->bind_param("i", $pegawai_id);
    $stmt_pegawai->execute();
    $result_pegawai = $stmt_pegawai->get_result();

    if ($result_pegawai->num_rows === 0) {
        throw new Exception('Pegawai dengan ID tersebut tidak ditemukan.');
    }

    $row_pegawai = $result_pegawai->fetch_assoc();
    $nama_pegawai = $row_pegawai['nama'];
    $email_pegawai = $row_pegawai['email'];

    $sql_slip_gaji = "SELECT sp.id AS slip_gaji_id, p.nama AS nama_pegawai, sp.file_path, gp.periode, gp.gaji_pokok, gp.tunjangan, gp.potongan, gp.bonus, gp.total_gaji
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

    $dompdf = new Dompdf();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf->setOptions($options);

    $html = '<html><head>';
    $html .= '<style>';
    $html .= 'body { font-family: Arial, sans-serif; }';
    $html .= 'h2 { text-align: center; margin-top: 20px; }';
    $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
    $html .= 'th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }';
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

    $slip_gaji_id = null;
    while ($row = $result_slip_gaji->fetch_assoc()) {
        $image_path = 'C:/laragon/www/keuangan/admin/gambar/' . $row['file_path'];
        $image_data = file_get_contents($image_path);
        $image_base64 = 'data:image/png;base64,' . base64_encode($image_data);
        $formatted_periode = date('j F Y', strtotime($row['periode']));

        $html .= '<tr>
                    <td>' . htmlspecialchars($row['nama_pegawai']) . '</td>
                    <td>' . htmlspecialchars($formatted_periode) . '</td>
                    <td>' . formatRupiah($row['gaji_pokok']) . '</td>
                    <td>' . formatRupiah($row['tunjangan']) . '</td>
                    <td>' . formatRupiah($row['potongan']) . '</td>
                    <td>' . formatRupiah($row['bonus']) . '</td>
                    <td>' . formatRupiah($row['total_gaji']) . '</td>
                    <td><img src="' . $image_base64 . '" alt="Gambar Slip Gaji"></td>
                </tr>';

        $slip_gaji_id = $row['slip_gaji_id'];
    }

    $html .= '</tbody></table>';
    $html .= '</body></html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $file_name = 'slip_gaji_' . str_replace(' ', '_', $nama_pegawai) . '_' . date('YmdHis') . '.pdf';
    $output_file = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/export_pdf/' . $file_name;
    file_put_contents($output_file, $dompdf->output());

    $download_url = 'http://' . $_SERVER['HTTP_HOST'] . '/keuangan/admin/export_pdf/' . $file_name;

    $sql_document = "INSERT INTO document (file_path, slip_gaji_id) VALUES (?, ?)";
    $stmt_document = $koneksi->prepare($sql_document);
    $stmt_document->bind_param("si", $file_name, $slip_gaji_id);
    $stmt_document->execute();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sikudes.panyiwi@gmail.com';
        $mail->Password = 'xwpf npne ksnd gbcd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sikudes.panyiwi@gmail.com', 'Admin Kantor Desa Panyili');
        $mail->addAddress($email_pegawai, $nama_pegawai);

        $mail->isHTML(true);
        $mail->Subject = 'Slip Gaji Periode ' . $start_date . ' - ' . $end_date;
        $mail->Body    = 'Berikut terlampir slip gaji Anda untuk periode ' . $start_date . ' sampai ' . $end_date . '.';
        $mail->addAttachment($output_file);

        $mail->send();
    } catch (Exception $e) {
        throw new Exception("Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}");
    }

    $response = array(
        'status' => 'success',
        'message' => 'PDF berhasil di-generate dan email telah dikirim.',
        'url' => $download_url
    );

    echo json_encode($response);
} catch (Exception $e) {
    $response = array(
        'status' => 'error',
        'message' => $e->getMessage()
    );
    echo json_encode($response);
}
?>