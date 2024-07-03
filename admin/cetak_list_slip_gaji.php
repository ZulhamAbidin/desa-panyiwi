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

$sql_pegawai = "SELECT id, nama, email FROM pegawai";
$result_pegawai = $koneksi->query($sql_pegawai);
?>

<style>
    #submit-btn.loading {
        position: relative;
    }

    #submit-btn.loading:before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid #fff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>


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
                            echo '<option value="' . $row['id'] . '" data-email="' . $row['email'] . '">' . $row['nama'] . '</option>';
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
                    <button type="button" id="submit-btn" class="btn btn-primary">Distribusikan Slip Gaji <span id="pegawai-info"></span></button>
                    <a id="download-link" href="" target="_blank" class="btn btn-primary d-none">Lihat Dokumen Yang Dikirim</a>
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
$("#pegawai_id").change(function() {
    var selectedOption = $(this).find(':selected');
    var namaPegawai = selectedOption.text();
    var emailPegawai = selectedOption.data('email');
    $("#submit-btn").html('Distribusikan Slip Gaji <span id="pegawai-info">ke ' + namaPegawai + ' dengan alamat email ' + emailPegawai + '</span>');
});


$("#submit-btn").click(function() {
    var pegawai_id = $("#pegawai_id").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var pegawai_email = $("#pegawai_id").find(':selected').data('email');
    var pegawai_name = $("#pegawai_id").find(':selected').text(); // Mendapatkan nama pegawai

    $("#submit-btn").addClass('loading').prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "controller/proses_export_slip_gaji.php",
        data: {
            pegawai_id: pegawai_id,
            start_date: start_date,
            end_date: end_date,
            pegawai_email: pegawai_email // Mengirimkan email pegawai ke proses_export_slip_gaji.php
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $("#download-link").attr('href', response.url).removeClass('d-none');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else if (response.status === 'error') {
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
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
                title: 'Info',
                text: 'Terjadi kesalahan saat memproses permintaan.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        },
        complete: function() {
            $("#submit-btn").removeClass('loading').prop('disabled', false);
        }
    });
});
</script>

<?php include 'src/footer.php'; ?>
