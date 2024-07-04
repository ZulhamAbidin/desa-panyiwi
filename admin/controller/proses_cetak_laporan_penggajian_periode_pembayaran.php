<?php
require_once '../../vendor/autoload.php';
include '../../koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$response = [];
file_put_contents(__DIR__ . '/debug.log', print_r($_POST, true), FILE_APPEND);

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception('Metode permintaan tidak valid.');
    }

    if (!isset($_POST['periode_pembayaran']) || empty($_POST['periode_pembayaran'])) {
        throw new Exception('Periode pembayaran tidak dipilih.');
    }

    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    function formatFileName($nama_pegawai) {
        $tanggal = date('d-m-Y-H-i');
        $formatted_name = strtolower(preg_replace('/\s+/', '-', trim($nama_pegawai)));
        return "export-data-penggajian-{$formatted_name}-{$tanggal}.pdf";
    }

    $periode_pembayaran = $_POST['periode_pembayaran'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $generated_files = [];

    // URL LOCAL
    $base_path = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/export_pdf/';

    
    // URL HOSTING
    // $base_path = $_SERVER['DOCUMENT_ROOT'] . '/admin/export_pdf/';
    
    
    if (!is_dir($base_path)) {
        if (!mkdir($base_path, 0755, true)) {
            throw new Exception('Tidak dapat membuat direktori: ' . $base_path);
        }
    }

    $sql_pegawai = "SELECT id, nama FROM pegawai WHERE periode_pembayaran = ?";
    $stmt_pegawai = $koneksi->prepare($sql_pegawai);
    if (!$stmt_pegawai) {
        throw new Exception('Error in SQL statement: ' . $koneksi->error);
    }
    $stmt_pegawai->bind_param("s", $periode_pembayaran);
    $stmt_pegawai->execute();
    $result_pegawai = $stmt_pegawai->get_result();

    while ($row_pegawai = $result_pegawai->fetch_assoc()) {
        $pegawai_id = $row_pegawai['id'];
        $nama_pegawai = $row_pegawai['nama'];

        $sql_slip_gaji = "SELECT gp.periode, gp.gaji_pokok, gp.tunjangan, gp.potongan, gp.bonus, gp.total_gaji
            FROM gaji_pegawai gp
            WHERE gp.pegawai_id = ? AND gp.periode BETWEEN ? AND ?";
        $stmt_slip_gaji = $koneksi->prepare($sql_slip_gaji);
        if (!$stmt_slip_gaji) {
            throw new Exception('Error in SQL statement: ' . $koneksi->error);
        }
        $stmt_slip_gaji->bind_param("iss", $pegawai_id, $start_date, $end_date);
        $stmt_slip_gaji->execute();
        $result_slip_gaji = $stmt_slip_gaji->get_result();

        $document_root = $_SERVER['DOCUMENT_ROOT'];
        $image_path = $document_root . '/keuangan/sash/images/brand/logo-2.png';

        $content = "
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                h2, h4 {
                    text-align: center;
                }
                .container {
                    padding: 20px;
                }
            </style>
            <div class='container'>
                <h2>Slip Gaji Pegawai</h2>
                <h4>Periode: " . htmlspecialchars($periode_pembayaran) . "</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Bonus</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        if ($result_slip_gaji->num_rows > 0) {
            while ($row_slip_gaji = $result_slip_gaji->fetch_assoc()) {
                $content .= "
                    <tr>
                        <td>" . htmlspecialchars($row_slip_gaji['periode']) . "</td>
                        <td>" . formatRupiah($row_slip_gaji['gaji_pokok']) . "</td>
                        <td>" . formatRupiah($row_slip_gaji['tunjangan']) . "</td>
                        <td>" . formatRupiah($row_slip_gaji['potongan']) . "</td>
                        <td>" . formatRupiah($row_slip_gaji['bonus']) . "</td>
                        <td>" . formatRupiah($row_slip_gaji['total_gaji']) . "</td>
                    </tr>
                ";
            }
        } else {
            $content .= "
                <tr>
                    <td colspan='6'>Tidak ada data</td>
                </tr>
            ";
        }

        $content .= "
                    </tbody>
                </table>
            </div>
        ";

        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdf_output = $dompdf->output();

        $file_name = formatFileName($nama_pegawai);
        $file_path = $base_path . $file_name;
        file_put_contents($file_path, $pdf_output);

        $generated_files[] = $file_name;
        $sql_insert = "INSERT INTO export_laporan_penggajian (pegawai_id, file_path) VALUES (?, ?)";
        $stmt_insert = $koneksi->prepare($sql_insert);
        if (!$stmt_insert) {
            throw new Exception('Error in SQL statement: ' . $koneksi->error);
        }
        $stmt_insert->bind_param("is", $pegawai_id, $file_name);
        if (!$stmt_insert->execute()) {
            throw new Exception('Error executing query: ' . $stmt_insert->error);
        }
    }

    $response = ['status' => 'success', 'files' => $generated_files];

} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
?>
