<?php

session_start();

if (isset($_SESSION['success_message'])) {
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
                icon: "info",
                title: "info",
                text: "' . $_SESSION['success_message'] . '",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });';
    echo '</script>';
    unset($_SESSION['success_message']);
}

?>

<?php
include 'src/header.php';
include '../koneksi.php';

$sql_pegawai = "SELECT id, nama FROM pegawai";
$result_pegawai = $koneksi->query($sql_pegawai);
?>

<div class="page-header">
    <h1 class="page-title">Cetak Slip Gaji</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="mb-5 text-center fw-bold">Cetak Slip Gaji</div>
        <form id="form-cetak">
            <div class="row">
                <div class="col-12">
                    <label class="mb-2" for="pegawai_id">Nama Pegawai:</label>
                    <select class="form-control" id="pegawai_id" name="pegawai_id" required>
                        <option value="" disabled selected>Pilih Pegawai</option>
                        <?php
                        while ($row = $result_pegawai->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
                        }
                        ?>
                    </select>
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
                    <button type="button" id="submit-btn" class="btn btn-primary">Cetak Laporan Slip Gaji</button>
                    <a id="download-link" href="" target="_blank" class="btn btn-primary d-none">Unduh Laporan PDF</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $("#submit-btn").click(function() {
        var pegawai_id = $("#pegawai_id").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        $.ajax({
            type: "POST",
            url: "controller/proses_export_slip_gaji.php",
            data: {
                pegawai_id: pegawai_id,
                start_date: start_date,
                end_date: end_date
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $("#download-link").attr('href', response.url).removeClass('d-none');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'PDF telah berhasil di-generate.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'info',
                        title: 'info',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'info',
                    title: 'info',
                    text: 'Terjadi kesalahan saat memproses permintaan.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>

<?php include 'src/footer.php'; ?>