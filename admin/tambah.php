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

function simpanLaporanKeuangan($uraian, $ref, $anggaran, $realisasi, $selisih, $periode, $kategori_id)
{
    global $koneksi;

    $uraian = mysqli_real_escape_string($koneksi, $uraian);
    $ref = mysqli_real_escape_string($koneksi, $ref);
    $anggaran = formatRupiahToNumber($anggaran);
    $realisasi = formatRupiahToNumber($realisasi);
    $selisih = formatRupiahToNumber($selisih);
    $periode = mysqli_real_escape_string($koneksi, $periode);
    $kategori_id = (int) $kategori_id;

    $sql = "INSERT INTO laporan_keuangan (uraian, ref, anggaran, realisasi, selisih, periode) 
            VALUES ('$uraian', '$ref', $anggaran, $realisasi, $selisih, '$periode')";

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
    $kategori_id = $_POST['kategori_id'];

    $sukses = simpanLaporanKeuangan($uraian, $ref, $anggaran, $realisasi, $selisih, $periode, $kategori_id);

    if ($sukses) {
        session_start();
        $_SESSION['success'] = "Laporan keuangan berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan laporan keuangan');</script>";
    }
    
}
?>

<div class="page-header">
    <h1 class="page-title">Tambah Data Keuangan</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group">
                    <label for="uraian">Uraian:</label>
                    <input type="text" class="form-control" id="uraian" name="uraian"
                        placeholder="Contoh : Bagi Hasil Pajak dan Retribusi" required>
                </div>

                <!-- <div class="form-group">
                    <label for="ref">Ref:</label>
                    <input type="text" class="form-control" id="ref" name="ref">
                </div> -->

                <div class="form-group">
                    <label for="anggaran">Anggaran:</label>
                    <input type="text" class="form-control" id="anggaran" name="anggaran"
                        placeholder="Contoh : Rp. 1.000.000" required>
                </div>

                <div class="form-group">
                    <label for="realisasi">Realisasi:</label>
                    <input type="text" class="form-control" id="realisasi" name="realisasi"
                        placeholder="Contoh : Rp. 500.000" required>
                </div>

                <div class="form-group">
                    <label for="selisih">Selisih:</label>
                    <input type="text" class="form-control" placeholder="Otomatis" id="selisih" name="selisih" readonly>
                </div>

                <div class="form-group">
                    <label for="periode">Periode:</label>
                    <input type="date" class="form-control" id="periode" name="periode" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select class="form-control" id="kategori" name="kategori_id" placeholder="" required>
                        <?php foreach ($kategoriList as $kategori) : ?>
                            <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- <a href="tambahh_kategori.php" class="">Tambah Kategori</a> -->
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio unde qui rem cupiditate? A dolorem illum itaque eaque consectetur impedit, ullam, doloribus recusandae quae reiciendis quasi enim, officiis neque beatae! -->

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

    // Fungsi untuk menghitung dan menampilkan selisih
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



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="../sash/js/jquery.min.js"></script>
<?php include 'src/footer.php'; ?>
