<?php
include 'src/header.php';
include '../koneksi.php';

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function formatRupiahToNumber($rupiah)
{
    return (int) preg_replace('/[^0-9]/', '', $rupiah);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($id)) {
    echo "ID pegawai tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['pegawai_id'];
    $gaji_pokok = formatRupiahToNumber($_POST['gaji_pokok']);
    $tunjangan = formatRupiahToNumber($_POST['tunjangan']);
    $bonus = formatRupiahToNumber($_POST['bonus']);
    $potongan = formatRupiahToNumber($_POST['potongan']);

    $sql = "UPDATE gaji_otomatis SET gaji_pokok = ?, tunjangan = ?, bonus = ?, potongan = ? WHERE pegawai_id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("iiiii", $gaji_pokok, $tunjangan, $bonus, $potongan, $pegawai_id);

    if ($stmt->execute()) {
        $stmt->close();
        $koneksi->close();

        session_start();
        $_SESSION['success_message'] = "Data berhasil disimpan!";
        header("Location: list_settingan.php");
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }

    $stmt->close();
}

$sql = "SELECT p.nama, go.gaji_pokok, go.tunjangan, go.bonus, go.potongan 
        FROM gaji_otomatis go 
        JOIN pegawai p ON go.pegawai_id = p.id 
        WHERE p.id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data gaji untuk pegawai dengan ID $id tidak ditemukan. Tambah data gaji untuk pegawai ini terlebih dahulu.";
    exit();
}

$stmt->close();
$koneksi->close();
?>

<div class="page-header">
    <h1 class="page-title">Edit Komponen Gaji Pegawai - <?php echo $data['nama']; ?></h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="edit_settingan.php?id=<?php echo $id; ?>" method="post" onsubmit="convertToNumberBeforeSubmit()">
            <input type="hidden" name="pegawai_id" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok:</label>
                <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?php echo formatRupiah($data['gaji_pokok']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="tunjangan" class="form-label">Tunjangan:</label>
                <input type="text" class="form-control" id="tunjangan" name="tunjangan" value="<?php echo formatRupiah($data['tunjangan']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="bonus" class="form-label">Bonus:</label>
                <input type="text" class="form-control" id="bonus" name="bonus" value="<?php echo formatRupiah($data['bonus']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="potongan" class="form-label">Potongan:</label>
                <input type="text" class="form-control" id="potongan" name="potongan" value="<?php echo formatRupiah($data['potongan']); ?>" required>
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
            document.getElementById('gaji_pokok').value = formatRupiahToNumber(document.getElementById('gaji_pokok').value);
            document.getElementById('tunjangan').value = formatRupiahToNumber(document.getElementById('tunjangan').value);
            document.getElementById('bonus').value = formatRupiahToNumber(document.getElementById('bonus').value);
            document.getElementById('potongan').value = formatRupiahToNumber(document.getElementById('potongan').value);
        };
    });
</script>

<?php include 'src/footer.php'; ?>
