<?php include 'src/header.php'; ?>
<?php
include '../koneksi.php';

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}

$query = 'SELECT id, nama FROM pegawai';
$result = $koneksi->query($query);
$pegawais = $result->fetch_all(MYSQLI_ASSOC);

?>

<div class="page-header">
    <h1 class="page-title">Cetak Laporan Penggajian</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-5 text-center fw-bold"> Cetak Berdasarkan Pegawai</div>
        <form action="controller/proses_cetak_laporan.php" method="post" id="cetak-laporan-form">
            <div class="row">
                <div class="col-12">
                    <label class="mb-2">Pilih Pegawai:</label><br>
                    <div class="row">
                        <?php foreach ($pegawais as $pegawai) : ?>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pegawai_<?php echo $pegawai['id']; ?>"
                                    name="selected_pegawais[]" value="<?php echo $pegawai['id']; ?>">
                                <label class="form-check-label" for="pegawai_<?php echo $pegawai['id']; ?>"><?php echo htmlspecialchars($pegawai['nama']); ?></label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-6 mb-4 mt-4">
                    <label for="start_date">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="col-6 mb-4 mt-4">
                    <label for="end_date">Tanggal Akhir:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="col-12 text-start">
                    <button type="submit" id="submit-btn" class="btn btn-primary">Cetak Laporan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cetak-laporan-form').submit(function(event) {
            event.preventDefault();

            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var selected_pegawais = [];

            $('input[name="selected_pegawais[]"]:checked').each(function() {
                selected_pegawais.push($(this).val());
            });

            var selected_pegawai_ids = selected_pegawais.join(',');

            window.location.href = 'controller/proses_cetak_laporan_penggajian.php?selected_pegawai_ids=' + selected_pegawai_ids + '&start_date=' + start_date + '&end_date=' + end_date;
        });
    });
</script>
<?php include 'src/footer.php'; ?>
