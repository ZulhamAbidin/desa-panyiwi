<?php
include '../../koneksi.php';

header('Content-Type: application/json'); // Pastikan respons berbentuk JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['pegawai_id'];
    $periode = $_POST['periode'];

    function getPeriodeType($pegawai_id) {
        global $koneksi;

        $sql = "SELECT periode_pembayaran FROM pegawai WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $pegawai_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $periode_pembayaran = $row['periode_pembayaran'];

        $stmt->close();
        return $periode_pembayaran;
    }

    function getNextPeriod($periode, $interval) {
        $periodeDate = date_create($periode);
        $nextPeriodDate = date_add($periodeDate, date_interval_create_from_date_string($interval));
        return date_format($nextPeriodDate, 'Y-m-d');
    }

    function validateSalary($pegawai_id, $periode, $periode_pembayaran) {
        global $koneksi;

        // Query untuk mendapatkan nama pegawai
        $sql_nama = "SELECT nama FROM pegawai WHERE id = ?";
        $stmt_nama = $koneksi->prepare($sql_nama);
        $stmt_nama->bind_param("i", $pegawai_id);
        $stmt_nama->execute();
        $result_nama = $stmt_nama->get_result();
        $row_nama = $result_nama->fetch_assoc();
        $nama_pegawai = $row_nama['nama'];
        $stmt_nama->close();

        $sql_check = "SELECT MAX(periode) AS last_payment FROM gaji_pegawai WHERE pegawai_id = ?";
        $stmt_check = $koneksi->prepare($sql_check);
        $stmt_check->bind_param("i", $pegawai_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $last_payment = $row_check['last_payment'];

        if ($last_payment) {
            $last_payment_date = date_create($last_payment);
            $current_period_date = date_create($periode);
            $diff_months = date_diff($last_payment_date, $current_period_date)->format('%m');

            $stmt_check->close();
            if ($periode_pembayaran == 'triwulanan' && $diff_months < 3) {
                return ['status' => 'exist', 'message' => 'Gaji untuk pegawai ' . $nama_pegawai . ' pada periode yang dipilih sudah ada atau belum waktunya untuk pembayaran karena belum genap 3 bulan. Silakan ganti periode atau periksa kapan terakhir kali ' . $nama_pegawai . ' dibayarkan.'];
            } elseif ($periode_pembayaran == 'bulanan' && $diff_months < 1) {
                return ['status' => 'exist', 'message' => 'Gaji untuk pegawai ' . $nama_pegawai . ' pada periode yang dipilih sudah ada atau belum waktunya untuk pembayaran karena belum genap 1 bulan. Silakan ganti periode atau periksa kapan terakhir kali ' . $nama_pegawai . ' dibayarkan.'];
            } elseif ($periode_pembayaran == 'tahunan' && $diff_months < 12) {
                return ['status' => 'exist', 'message' => 'Gaji untuk pegawai ' . $nama_pegawai . ' pada periode yang dipilih sudah ada atau belum waktunya untuk pembayaran karena belum genap 1 tahun. Silakan ganti periode atau periksa kapan terakhir kali ' . $nama_pegawai . ' dibayarkan.'];
            } else {
                return ['status' => 'not_exist'];
            }
            
        } else {
            $stmt_check->close();
            return ['status' => 'not_exist'];
        }
    }

    $periode_pembayaran = getPeriodeType($pegawai_id);
    $validationResult = validateSalary($pegawai_id, $periode, $periode_pembayaran);

    echo json_encode($validationResult);
}
?>
