<?php include 'src/header.php'; ?>
<?php
include '../koneksi.php';

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

$query = "SELECT id, nama_kategori FROM kategori";
$result = $koneksi->query($query);
$kategoris = $result->fetch_all(MYSQLI_ASSOC);

?>

<div class="page-header">
    <h1 class="page-title">Cetak Laporan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="controller/proses_cetak_laporan.php" method="post" id="cetak-laporan-form">
            <div class="form-group" id="kategori-list">
                <label>Pilih Kategori:</label><br>
                <?php foreach ($kategoris as $kategori) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="kategori_<?php echo $kategori['id']; ?>" name="kategori[]" value="<?php echo $kategori['id']; ?>">
                        <label class="form-check-label" for="kategori_<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" id="submit-btn" class="btn btn-primary">Cetak Laporan</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#cetak-laporan-form').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting normally
            
            var kategori = [];
            $.each($("input[name='kategori[]']:checked"), function(){
                kategori.push($(this).val());
            });
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            // Redirect to the processing script with the parameters
            window.location.href = 'controller/proses_cetak_laporan.php?kategori=' + kategori.join(',') + '&start_date=' + start_date + '&end_date=' + end_date;
        });
    });
</script>

<?php include 'src/footer.php'; ?>
