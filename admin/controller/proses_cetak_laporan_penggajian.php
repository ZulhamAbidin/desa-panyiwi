<?php
require_once '../../vendor/autoload.php';
include '../../koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

try {
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        throw new Exception('Metode permintaan tidak valid.');
    }

    if (!isset($_GET['selected_pegawai_ids']) || empty($_GET['selected_pegawai_ids'])) {
        throw new Exception('Tidak ada pegawai yang dipilih.');
    }

    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    $selected_pegawai_ids = explode(",", $_GET['selected_pegawai_ids']);
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $generated_files = [];

    foreach ($selected_pegawai_ids as $pegawai_id) {
        $sql_pegawai = "SELECT id, nama FROM pegawai WHERE id = ?";
        $stmt_pegawai = $koneksi->prepare($sql_pegawai);
        $stmt_pegawai->bind_param("i", $pegawai_id);
        $stmt_pegawai->execute();
        $result_pegawai = $stmt_pegawai->get_result();

        if ($result_pegawai->num_rows === 0) {
            continue;
        }

        $row_pegawai = $result_pegawai->fetch_assoc();
        $nama_pegawai = $row_pegawai['nama'];

        $sql_slip_gaji = "SELECT gp.periode, gp.gaji_pokok, gp.tunjangan, gp.potongan, gp.bonus, gp.total_gaji
            FROM gaji_pegawai gp
            WHERE gp.pegawai_id = ? AND gp.periode BETWEEN ? AND ?";
        $stmt_slip_gaji = $koneksi->prepare($sql_slip_gaji);
        $stmt_slip_gaji->bind_param("iss", $pegawai_id, $start_date, $end_date);
        $stmt_slip_gaji->execute();
        $result_slip_gaji = $stmt_slip_gaji->get_result();

        if ($result_slip_gaji->num_rows === 0) {
            continue;
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
        $html .= '.header { text-align: center; margin-bottom: 20px; }';
        $html .= '.header img { max-width: 100px; }'; // Sesuaikan dengan ukuran logo
        $html .= '.alamat-instansi { text-align: center; margin-bottom: 10px; font-size: 18px; font-weight: bold; }';
        $html .= '.teks-h5 { text-align: center; font-size: 14px; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
        $html .= 'th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }';
        $html .= '</style>';
        $html .= '</head><body>';

        // Header
        

        $html .= '<h2>Laporan Slip Gaji - ' . htmlspecialchars($nama_pegawai) . '</h2><br>';
        $html .= '<table>
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
                    <tbody>';

        while ($row_slip_gaji = $result_slip_gaji->fetch_assoc()) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($row_slip_gaji['periode']) . '</td>
                        <td>' . formatRupiah($row_slip_gaji['gaji_pokok']) . '</td>
                        <td>' . formatRupiah($row_slip_gaji['tunjangan']) . '</td>
                        <td>' . formatRupiah($row_slip_gaji['potongan']) . '</td>
                        <td>' . formatRupiah($row_slip_gaji['bonus']) . '</td>
                        <td>' . formatRupiah($row_slip_gaji['total_gaji']) . '</td>
                    </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '</body></html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $file_name = 'export-data-' . strtolower(str_replace(' ', '-', $nama_pegawai)) . '-' . date('dmYHis') . '.pdf';
        $output_file = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/export_pdf/' . $file_name;
        file_put_contents($output_file, $dompdf->output());

        // Simpan ke database
        $sql_insert = "INSERT INTO export_laporan_penggajian (pegawai_id, file_path) VALUES (?, ?)";
        $stmt_insert = $koneksi->prepare($sql_insert);
        $stmt_insert->bind_param("is", $pegawai_id, $file_name);
        $stmt_insert->execute();

        $generated_files[] = $file_name;
    }

    $response = array(
        'status' => 'success',
        'message' => 'PDF berhasil di-generate dan disimpan.',
        'files' => $generated_files
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
