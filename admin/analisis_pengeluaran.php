<?php include 'src/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Analisis Pengeluaran Gaji Pegawai</h1>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="mb-4 text-center fw-bold">Analisis Pengeluaran Gaji Pegawai</div>

            <form id="formRentangWaktu" class="mb-4">
                <div class="mb-3">
                    <label for="tanggalMulai" class="form-label">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai" required>
                </div>

                <div class="mb-3">
                    <label for="tanggalAkhir" class="form-label">Tanggal Akhir:</label>
                    <input type="date" class="form-control" id="tanggalAkhir" name="tanggal_akhir" required>
                </div>

                <button type="submit" class="btn btn-primary">Hitung Total Gaji</button>
            </form>

            <div id="hasilTotalGaji"></div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#formRentangWaktu').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'controller/proses.php',
                data: formData,
                dataType: 'html',
                success: function (data) {
                    $('#hasilTotalGaji').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>

<?php include 'src/footer.php'; ?>
