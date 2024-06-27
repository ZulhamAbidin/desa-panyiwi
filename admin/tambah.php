<?php include 'src/header.php'; ?>

<?php
$query = "SELECT * FROM kategori";
$result = $koneksi->query($query);
$kategoriList = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kategoriList[] = $row;
    }
}

function formatRupiahToNumber($rupiah)
{
    return (int) preg_replace('/[^0-9]/', '', $rupiah);
}

function simpanLaporanKeuangan($uraian, $ref, $anggaran, $realisasi, $selisih, $periode, $deskripsi_gambar, $kategori_id, $gambar)
{
    global $koneksi;

    $uraian = mysqli_real_escape_string($koneksi, $uraian);
    $ref = mysqli_real_escape_string($koneksi, $ref);
    $anggaran = formatRupiahToNumber($anggaran);
    $realisasi = formatRupiahToNumber($realisasi);
    $selisih = formatRupiahToNumber($selisih);
    $deskripsi_gambar = mysqli_real_escape_string($koneksi, $deskripsi_gambar);
    $periode = mysqli_real_escape_string($koneksi, $periode);
    $kategori_id = (int) $kategori_id;
    $gambarPath = null;
    if ($gambar['error'] === UPLOAD_ERR_OK) {
        $filename = uniqid('gambar_') . '.' . pathinfo($gambar['name'], PATHINFO_EXTENSION);
        $targetDir = 'admin/gambar/';
        $targetPath = __DIR__ . '/../' . $targetDir . $filename;
    
        if (move_uploaded_file($gambar['tmp_name'], $targetPath)) {
            $gambarPath = $filename;
        } else {
            echo "Gagal mengunggah gambar. Silakan coba lagi.";
            return false;
        }
    }

    $sql = "INSERT INTO laporan_keuangan (uraian, ref, anggaran, realisasi, selisih, periode, deskripsi_gambar, gambar) 
            VALUES ('$uraian', '$ref', $anggaran, $realisasi, $selisih, '$periode', '$deskripsi_gambar', '$gambarPath')";

    if ($koneksi->query($sql) === true) {
        $laporan_id = $koneksi->insert_id;

        $sql_laporan_kategori = "INSERT INTO laporan_kategori (laporan_id, kategori_id) 
                                 VALUES ($laporan_id, $kategori_id)";
        if ($koneksi->query($sql_laporan_kategori) === true) {
            return true;
        } else {
            echo "Error: " . $sql_laporan_kategori . "<br>" . $koneksi->error;
            return false;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uraian = $_POST['uraian'];
    $ref = isset($_POST['ref']) ? $_POST['ref'] : null;
    $anggaran = $_POST['anggaran'];
    $realisasi = $_POST['realisasi'];
    $selisih = $_POST['selisih'];
    $periode = $_POST['periode'];
    $deskripsi_gambar = $_POST['deskripsi_gambar'];
    $kategori_id = $_POST['kategori_id'];
    $gambar = $_FILES['gambar'];
    $sukses = simpanLaporanKeuangan($uraian, $ref, $anggaran, $realisasi, $selisih, $periode, $deskripsi_gambar, $kategori_id, $gambar);

    if ($sukses) {
        $_SESSION['success_message'] = "Laporan keuangan berhasil disimpan";
    } else {
        $_SESSION['error_message'] = "Gagal menyimpan laporan keuangan";
    }
    header("Location: list.php");
    exit();
}
?>

<div class="page-header">
    <h1 class="page-title">Tambah Data Keuangan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
                    <label for="uraian">Uraian:</label>
                    <textarea class="form-control" rows="4" name="uraian" id="uraian" required></textarea>
                </div>

                <div class="col-12 col-md-6">
                    <label for="ref">Ref:</label>
                    <input type="text" class="form-control" id="ref" name="ref">
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="anggaran">Anggaran:</label>
                    <input type="text" class="form-control" id="anggaran" name="anggaran"
                        placeholder="Contoh : Rp. 1.000.000" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="realisasi">Realisasi:</label>
                    <input type="text" class="form-control" id="realisasi" name="realisasi"
                        placeholder="Contoh : Rp. 500.000" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="selisih">Selisih:</label>
                    <input type="text" class="form-control" placeholder="Otomatis" id="selisih" name="selisih" readonly>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="periode">Periode:</label>
                    <input type="date" class="form-control" id="periode" name="periode" placeholder="" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="kategori">Kategori:</label>
                    <select class="form-control" id="kategori" name="kategori_id" placeholder="" required>
                        <?php foreach ($kategoriList as $kategori) : ?>
                        <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-12 mb-4">
                    <label for="gambar">Gambar:</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                </div>

                <div class="col-12 col-md-12 mb-4">
                    <label for="deskripsi_gambar">Deskripsi Gambar:</label>
                    <textarea type="text" rows="4" class="form-control" id="deskripsi_gambar" name="deskripsi_gambar" value="" required> </textarea>
                </div>

                <div class="col-12 col-md-12 text-end mb-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    var anggaranInput = document.getElementById("anggaran");
    var realisasiInput = document.getElementById("realisasi");
    var selisihInput = document.getElementById("selisih");

    anggaranInput.addEventListener("input", formatInput);
    realisasiInput.addEventListener("input", formatInput);

    function formatInput() {
        var anggaranValue = anggaranInput.value;
        var realisasiValue = realisasiInput.value;

        anggaranInput.value = formatRupiah(anggaranValue);
        realisasiInput.value = formatRupiah(realisasiValue);

        hitungSelisih();
    }

    function hitungSelisih() {
        var anggaran = parseFloat(anggaranInput.value.replace(/[^\d]/g, ""));
        var realisasi = parseFloat(realisasiInput.value.replace(/[^\d]/g, ""));

        var selisih = realisasi - anggaran;

        selisihInput.value = formatRupiah(Math.abs(selisih), "Rp. ");

        if (selisih < 0) {
            selisihInput.value = "+" + selisihInput.value;
        } else {
            selisihInput.value = "-" + selisihInput.value;
        }
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, "");
        var split = number_string.split(",");
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

        return prefix === undefined ? (rupiah ? "Rp. " + rupiah : "") : (rupiah ? prefix + rupiah : "");
    }
</script>

<?php include 'src/footer.php'; ?>