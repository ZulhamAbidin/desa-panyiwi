<?php include 'src/header.php'; ?>
<?php
include '../koneksi.php';

if ($koneksi->connect_error) {
    die('Connection failed: ' . $koneksi->connect_error);
}

$query = 'SELECT id, nama_kategori FROM kategori';
$result = $koneksi->query($query);
$kategoris = $result->fetch_all(MYSQLI_ASSOC);

?>

<div class="page-header">
    <h1 class="page-title">Cetak Laporan</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-5 text-center fw-bold"> Cetak Berdasarkan Kategori</div>
        <form action="controller/proses_cetak_laporan.php" method="post" id="cetak-laporan-form">
            <div class="row">
                <div class="col-12" id="kategori-list">
                    <label clas="mb-2">Pilih Kategori:</label><br>
                    <div class="row">
                        <?php foreach ($kategoris as $kategori) : ?>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kategori_<?php echo $kategori['id']; ?>"
                                    name="kategori[]" value="<?php echo $kategori['id']; ?>">
                                <label class="form-check-label"
                                    for="kategori_<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></label>
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

<div class="card">
    <div class="card-body mt-4">
        <div class="mb-5 text-center fw-bold"> Cetak Berdasarkan Yang Dipilih</div>
        <form action="controller/proses-cetak-selected.php" method="post" id="cetak-laporan-form">
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Uraian</th>
                        <th>Ref</th>
                        <th>Anggaran</th>
                        <th>Realisasi</th>
                        <th>Selisih</th>
                        <th>Periode</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Cetak Laporan</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<script>
   $(document).ready(function() {
    $('#data-table').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "controller/get-selected.php",
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "orderable": false,
                render: function(data, type, row) {
                    return '<input type="checkbox" name="selected_ids[]" value="' + row.id + '">';
                }
            },
            { "data": "uraian" },
            { "data": "ref" },
            { 
                "data": "anggaran",
                render: function(data) {
                    return 'Rp ' + numberFormat(data);
                }
            },
            { 
                "data": "realisasi",
                render: function(data) {
                    return 'Rp ' + numberFormat(data);
                }
            },
            { 
                "data": "selisih",
                render: function(data) {
                    var sign = data.charAt(0);
                    var value = data.substring(1);
                    return sign + ' Rp ' + numberFormat(value);
                }
            },
            { 
                "data": "periode",
                render: function(data) {
                    var date = new Date(data);
                    return date.getFullYear();
                }
            },
            { "data": "nama_kategori" }
        ],
        "order": [[1, 'asc']]
    });

    function numberFormat(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'decimal'
        }).format(number);
    }

    $('#select-all').click(function() {
        var checked = this.checked;
        $('input[name="selected_ids[]"]').each(function() {
            this.checked = checked;
        });
    });
});

</script>

<script>
    $(document).ready(function() {
        $('#cetak-laporan-form').submit(function(event) {
            event.preventDefault();

            var kategori = [];
            $.each($("input[name='kategori[]']:checked"), function() {
                kategori.push($(this).val());
            });
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            window.location.href = 'controller/proses_cetak_laporan.php?kategori=' + kategori.join(
                ',') + '&start_date=' + start_date + '&end_date=' + end_date;
        });
    });
</script>
<?php include 'src/footer.php'; ?>