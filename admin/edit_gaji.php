<?php
include 'src/header.php';
include '../koneksi.php';

function formatRupiahToNumber($rupiah)
{
    return (int) preg_replace('/[^0-9]/', '', $rupiah);
}

$id = $_GET['id'];
$pegawai_id = $periode = $gaji_pokok = $tunjangan = $potongan = $bonus = $tanggal_pembayaran = $metode_pembayaran = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $pegawai_id = $_POST['pegawai_id'];
    $periode = $_POST['periode'];
    $gaji_pokok = formatRupiahToNumber($_POST['gaji_pokok']);
    $tunjangan = isset($_POST['tunjangan']) ? formatRupiahToNumber($_POST['tunjangan']) : 0;
    $potongan = isset($_POST['potongan']) ? formatRupiahToNumber($_POST['potongan']) : 0;
    $bonus = isset($_POST['bonus']) ? formatRupiahToNumber($_POST['bonus']) : 0;
    $total_gaji = $gaji_pokok + $tunjangan - $potongan + $bonus;
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/keuangan/admin/gambar/';
    $file_path = '';

    if ($_FILES['bukti_pembayaran']['size'] > 0) {
        $fileName = basename($_FILES['bukti_pembayaran']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $randomFileName = uniqid() . '.' . $fileExtension;
        $file_path = $randomFileName;
        $targetPath = $uploadDir . $randomFileName;
        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $targetPath)) {
            $sql_update = "UPDATE slip_gaji SET file_path = ? WHERE gaji_pegawai_id = ?";
            $stmt_update = $koneksi->prepare($sql_update);
            $stmt_update->bind_param("si", $file_path, $id);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $_SESSION['error_message'] = "Gagal mengunggah bukti pembayaran.";
        }
    }

    if (empty($error_message)) {
        $sql = "UPDATE gaji_pegawai SET pegawai_id = ?, periode = ?, gaji_pokok = ?, tunjangan = ?, potongan = ?, bonus = ?, total_gaji = ?, tanggal_pembayaran = ?, metode_pembayaran = ? WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("isddddsssi", $pegawai_id, $periode, $gaji_pokok, $tunjangan, $potongan, $bonus, $total_gaji, $tanggal_pembayaran, $metode_pembayaran, $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Gaji pegawai berhasil diperbarui!";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui gaji pegawai: " . $koneksi->error;
        }
        $stmt->close();

        header("Location: list_gaji.php");
        exit();
    }
} else {
    $sql = "SELECT * FROM gaji_pegawai WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $pegawai_id = $row['pegawai_id'];
        $periode = $row['periode'];
        $gaji_pokok = $row['gaji_pokok'];
        $tunjangan = $row['tunjangan'];
        $potongan = $row['potongan'];
        $bonus = $row['bonus'];
        $tanggal_pembayaran = $row['tanggal_pembayaran'];
        $metode_pembayaran = $row['metode_pembayaran'];
    } else {
        $_SESSION['error_message'] = "Data tidak ditemukan!";
        header("Location: list_gaji.php");
        exit();
    }
    $stmt->close();
}
?>

<div class="page-header">
    <h1 class="page-title">Edit Gaji Pegawai</h1>
</div>

<?php if (!empty($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <label for="pegawai_id">Pegawai:</label>
                    <select class="form-control" id="pegawai_id" name="pegawai_id" required>
                        <?php
                        $sql_pegawai = "SELECT id, nama FROM pegawai";
                        $result_pegawai = $koneksi->query($sql_pegawai);
                        while ($row = $result_pegawai->fetch_assoc()) {
                            $selected = ($row['id'] == $pegawai_id) ? 'selected' : '';
                            echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nama'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="periode">Periode:</label>
                    <input type="date" class="form-control" id="periode" name="periode" value="<?php echo $periode; ?>" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="gaji_pokok">Gaji Pokok:</label>
                    <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?php echo $gaji_pokok; ?>" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="tunjangan">Tunjangan:</label>
                    <input type="text" class="form-control" id="tunjangan" name="tunjangan" value="<?php echo $tunjangan; ?>">
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="potongan">Potongan:</label>
                    <input type="text" class="form-control" id="potongan" name="potongan" value="<?php echo $potongan; ?>">
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="bonus">Bonus:</label>
                    <input type="text" class="form-control" id="bonus" name="bonus" value="<?php echo $bonus; ?>">
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="tanggal_pembayaran">Tanggal Pembayaran:</label>
                    <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo $tanggal_pembayaran; ?>" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="metode_pembayaran">Metode Pembayaran:</label>
                    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="" disabled>Pilih Metode Pembayaran</option>
                        <option value="Transfer Bank" <?php echo $metode_pembayaran == 'Transfer Bank' ? 'selected' : ''; ?>>Transfer Bank</option>
                        <option value="Cash" <?php echo $metode_pembayaran == 'Cash' ? 'selected' : ''; ?>>Cash</option>
                        <option value="Gopay" <?php echo $metode_pembayaran == 'Gopay' ? 'selected' : ''; ?>>Gopay</option>
                        <option value="OVO" <?php echo $metode_pembayaran == 'OVO' ? 'selected' : ''; ?>>OVO</option>
                        <option value="Dana" <?php echo $metode_pembayaran == 'Dana' ? 'selected' : ''; ?>>Dana</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="total_gaji">Total Gaji:</label>
                    <input type="text" class="form-control" id="total_gaji" name="total_gaji" value="<?php echo $total_gaji; ?>" readonly>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="bukti_pembayaran">Bukti Pembayaran (Optional):</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var formatRupiah = function (angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                var separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? "Rp. " + rupiah : "");
        };

        var formatRupiahToNumber = function (rupiah) {
            return parseInt(rupiah.replace(/[^0-9]/g, ''), 10) || 0;
        };

        var updateTotalGaji = function () {
            var gaji_pokok = formatRupiahToNumber(document.getElementById('gaji_pokok').value);
            var tunjangan = formatRupiahToNumber(document.getElementById('tunjangan').value);
            var potongan = formatRupiahToNumber(document.getElementById('potongan').value);
            var bonus = formatRupiahToNumber(document.getElementById('bonus').value);
            var total_gaji = gaji_pokok + tunjangan - potongan + bonus;
            document.getElementById('total_gaji').value = formatRupiah(total_gaji.toString(), 'Rp. ');
        };

        document.querySelectorAll('input[type=text]').forEach(function (input) {
            if (input.value && input.id !== 'metode_pembayaran') {
                input.value = formatRupiah(input.value, 'Rp. ');
            }
        });

        document.querySelectorAll('input[type=text]').forEach(function (input) {
            input.addEventListener('input', function () {
                if (input.id !== 'metode_pembayaran') {
                    input.value = formatRupiah(input.value, 'Rp. ');
                    updateTotalGaji();
                }
            });
        });

        updateTotalGaji();
    });
</script>

<?php
include 'src/footer.php';
?>
