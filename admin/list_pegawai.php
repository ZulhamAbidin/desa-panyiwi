<?php include 'src/header.php'; ?>

<?php
if (isset($_SESSION['success_message'])) {
    echo '
    <script>
    $(document).ready(function() {
        var toastSuccess = new bootstrap.Toast(document.getElementById("toastSuccess"));
        $(".toast-body", toastSuccess.element).text("' . $_SESSION['success_message'] . '");
        toastSuccess.show();
    });
    </script>
    ';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '
    <script>
    $(document).ready(function() {
        var toastError = new bootstrap.Toast(document.getElementById("toastError"));
        $(".toast-body", toastError.element).text("' . $_SESSION['error_message'] . '");
        toastError.show();
    });
    </script>
    ';
    unset($_SESSION['error_message']);
}
?>

<div class="page-header">
    <h1 class="page-title">List Data Pegawai</h1>
    <div>
        <ol class="breadcrumb">
            <a href="create_pegawai.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Data Pegawai</a>
        </ol>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="pegawaiTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Nomor Identifikasi</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Periode Pembayaran</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <!-- Toast Success -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toastSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Success message will be inserted here -->
                </div>
            </div>
        </div>

        <!-- Toast Error -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toastError" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Error message will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#pegawaiTable').DataTable({
            "responsive": true,
            "ajax": {
                "url": "controller/fetch_pegawai.php",
                "type": "GET"
            },
            "columns": [
                { "data": "No" },
                { "data": "Nama" },
                { "data": "Jabatan" },
                { "data": "Nomor Identifikasi" },
                { "data": "Email" },
                { "data": "Nomor Telepon" },
                { "data": "Alamat" },
                { "data": "Periode Pembayaran" },
                { "data": "Action" }
            ]
        });

        $('#pegawaiTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus data: " + nama,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'controller/delete_pegawai.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                table.ajax.reload();
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghubungi server.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
<?php include 'src/footer.php'; ?>