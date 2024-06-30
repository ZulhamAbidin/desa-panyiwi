<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['pegawai_id'];
    $periode = $_POST['periode'];

    // Fungsi untuk mendapatkan jenis periode dari tabel pegawai
    function getPeriodeType($pegawai_id) {
        global $koneksi;

        $sql = "SELECT periode_pembayaran FROM pegawai WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $pegawai_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $periode_pembayaran = $row['periode_pembayaran'];

        return $periode_pembayaran;
    }

    // Fungsi untuk mendapatkan jenis periode berdasarkan tanggal periode
    function getPeriodeTypeFromDate($periode) {
        $currentDate = date('Y-m-d');
        $periodeDate = date('Y-m-d', strtotime($periode));

        $diffMonths = (int) date_diff(date_create($currentDate), date_create($periodeDate))->format('%m');
        $diffYears = (int) date_diff(date_create($currentDate), date_create($periodeDate))->format('%y');

        if ($diffYears > 0) {
            return 'tahunan';
        } elseif ($diffMonths >= 3) {
            return 'triwulan';
        } else {
            return 'bulanan';
        }
    }

    // Fungsi untuk mendapatkan tanggal periode berikutnya (1 bulan dan 1 tahun kedepan)
    function getNextPeriod($periode, $interval) {
        $periodeDate = date_create($periode);
        $nextPeriodDate = date_add($periodeDate, date_interval_create_from_date_string($interval));
        return date_format($nextPeriodDate, 'Y-m-d');
    }

    // Panggil fungsi untuk mendapatkan jenis periode berdasarkan tanggal periode yang dipilih
    $periodeType = getPeriodeTypeFromDate($periode);

    if ($periodeType == 'triwulan') {
        // Query untuk mendapatkan data gaji pegawai pada periode triwulan terakhir
        $sql_check = "SELECT MAX(periode) AS last_payment FROM gaji_pegawai WHERE pegawai_id = ?";
        $stmt_check = $koneksi->prepare($sql_check);
        $stmt_check->bind_param("i", $pegawai_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $last_payment = $row_check['last_payment'];

        if ($last_payment) {
            // Jika sudah ada pembayaran sebelumnya, hitung berapa bulan sejak pembayaran terakhir
            $last_payment_date = date_create($last_payment);
            $current_period_date = date_create($periode);
            $diff_months = date_diff($last_payment_date, $current_period_date)->format('%m');

            if ($diff_months < 3) {
                // Jika belum 3 bulan sejak pembayaran terakhir, gaji belum dapat dibuat
                echo json_encode(['status' => 'exist', 'message' => 'Gaji untuk pegawai ini pada periode triwulan ini sudah ada atau belum waktunya untuk pembayaran.']);
            } else {
                // Jika sudah lebih dari 3 bulan, gaji dapat dibuat
                echo json_encode(['status' => 'not_exist']);
            }
        } else {
            // Jika belum ada pembayaran sebelumnya, gaji dapat dibuat
            echo json_encode(['status' => 'not_exist']);
        }
    } else {
        // Untuk jenis periode lainnya (bulanan atau tahunan), lakukan pengecekan biasa
        $sql_check = "SELECT COUNT(*) as count FROM gaji_pegawai WHERE pegawai_id = ? AND YEAR(periode) = YEAR(?)";
        $stmt_check = $koneksi->prepare($sql_check);
        $stmt_check->bind_param("is", $pegawai_id, $periode);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();

        if ($row_check['count'] > 0) {
            // Jika sudah ada data gaji untuk pegawai pada periode tertentu
            echo json_encode(['status' => 'exist', 'message' => 'Gaji untuk pegawai ini pada periode tersebut sudah ada.']);
        } else {
            // Jika belum ada data gaji untuk pegawai pada periode tertentu
            // Tambahan: cek untuk periode 1 bulan dan 1 tahun ke depan
            $nextMonth = getNextPeriod($periode, '+1 month');
            $nextYear = getNextPeriod($periode, '+1 year');

            $sql_next_month = "SELECT COUNT(*) as count FROM gaji_pegawai WHERE pegawai_id = ? AND YEAR(periode) = YEAR(?) AND MONTH(periode) = MONTH(?)";
            $stmt_next_month = $koneksi->prepare($sql_next_month);
            $stmt_next_month->bind_param("iss", $pegawai_id, $nextMonth, $nextMonth);
            $stmt_next_month->execute();
            $result_next_month = $stmt_next_month->get_result();
            $row_next_month = $result_next_month->fetch_assoc();

            $sql_next_year = "SELECT COUNT(*) as count FROM gaji_pegawai WHERE pegawai_id = ? AND YEAR(periode) = YEAR(?)";
            $stmt_next_year = $koneksi->prepare($sql_next_year);
            $stmt_next_year->bind_param("is", $pegawai_id, $nextYear);
            $stmt_next_year->execute();
            $result_next_year = $stmt_next_year->get_result();
            $row_next_year = $result_next_year->fetch_assoc();

            if ($row_next_month['count'] > 0 || $row_next_year['count'] > 0) {
                // Jika sudah ada data gaji untuk pegawai pada periode 1 bulan atau 1 tahun ke depan
                echo json_encode(['status' => 'exist', 'message' => 'Gaji untuk pegawai ini pada periode 1 bulan atau 1 tahun ke depan sudah ada.']);
            } else {
                // Jika belum ada data gaji untuk pegawai pada periode 1 bulan atau 1 tahun ke depan
                echo json_encode(['status' => 'not_exist']);
            }
        }
    }

    // Tutup statement
    $stmt_check->close();
}
?>