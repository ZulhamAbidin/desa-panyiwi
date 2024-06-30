<?php
include 'src/header.php';
include '../koneksi.php';

function formatRupiahToNumber($rupiah)
{
    return (int) preg_replace('/[^0-9]/', '', $rupiah);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_ids = $_POST['pegawai_id'];
    $gaji_pokok = formatRupiahToNumber($_POST['gaji_pokok']);
    $tunjangan = formatRupiahToNumber($_POST['tunjangan']);
    $bonus = formatRupiahToNumber($_POST['bonus']);
    $potongan = formatRupiahToNumber($_POST['potongan']);

    $error_message = '';

    foreach ($pegawai_ids as $pegawai_id) {
        $pegawai_id = trim($pegawai_id);

        $result = $koneksi->query("SELECT id FROM pegawai WHERE id = '$pegawai_id'");
        if ($result->num_rows > 0) {
            $sql = "INSERT INTO gaji_otomatis (pegawai_id, gaji_pokok, tunjangan, bonus, potongan)
                    VALUES ('$pegawai_id', '$gaji_pokok', '$tunjangan', '$bonus', '$potongan')
                    ON DUPLICATE KEY UPDATE
                    gaji_pokok = VALUES(gaji_pokok),
                    tunjangan = VALUES(tunjangan),
                    bonus = VALUES(bonus),
                    potongan = VALUES(potongan)";
            $koneksi->query($sql);
        } else {
            $error_message .= "Pegawai dengan ID $pegawai_id tidak ditemukan.<br>";
        }
    }

    $koneksi->close();

    if (empty($error_message)) {
        header("Location: settingan_gaji.php");
        exit();
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Settingan Gaji Pegawai</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="settingan_gaji.php" method="post" onsubmit="convertToNumberBeforeSubmit()">
            <div class="mb-3">
                <label for="pegawai_id" class="form-label">ID Pegawai:</label>
                <select class="form-control select2" id="pegawai_id" name="pegawai_id[]" multiple="multiple" required>
                    <?php
                    $result = $koneksi->query("SELECT id, nama FROM pegawai");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['nama']} (ID: {$row['id']})</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok:</label>
                <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" required>
            </div>

            <div class="mb-3">
                <label for="tunjangan" class="form-label">Tunjangan:</label>
                <input type="text" class="form-control" id="tunjangan" name="tunjangan" required>
            </div>

            <div class="mb-3">
                <label for="bonus" class="form-label">Bonus:</label>
                <input type="text" class="form-control" id="bonus" name="bonus" required>
            </div>

            <div class="mb-3">
                <label for="potongan" class="form-label">Potongan:</label>
                <input type="text" class="form-control" id="potongan" name="potongan" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.select2').select2({
            placeholder: 'Pilih Pegawai',
            width: '100%'
        });

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

        document.querySelectorAll('input[type=text]').forEach(function (input) {
            input.addEventListener('input', function () {
                input.value = formatRupiah(input.value, 'Rp. ');
            });
        });

        window.convertToNumberBeforeSubmit = function () {
            document.getElementById('gaji_pokok').value = formatRupiahToNumber(document.getElementById(
                'gaji_pokok').value);
            document.getElementById('tunjangan').value = formatRupiahToNumber(document.getElementById(
                'tunjangan').value);
            document.getElementById('bonus').value = formatRupiahToNumber(document.getElementById('bonus')
                .value);
            document.getElementById('potongan').value = formatRupiahToNumber(document.getElementById(
                'potongan').value);
        };
    });
</script>

<?php include 'src/footer.php'; ?>
