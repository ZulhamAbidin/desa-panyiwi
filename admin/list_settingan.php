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
    <h1 class="page-title">List Komponen Gaji</h1>
    <div>
        <ol class="breadcrumb">
            <a href="create_settingan.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Komponen Gaji</a>
        </ol>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="create_settingan" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Bonus</th>
                    <th>Potongan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <!-- Toast Success -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toastSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Sukses</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Pesan sukses akan dimasukkan di sini -->
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
                    <!-- Pesan error akan dimasukkan di sini -->
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
$(document).ready(function () {
    var table = $('#create_settingan').DataTable({
        "responsive": true,
        "ajax": {
            "url": "controller/fetch_settingan.php",
            "type": "GET"
        },
        "columns": [
            { "data": "No" },
            { "data": "Nama" },
            { "data": "Gaji Pokok" },
            { "data": "Tunjangan" },
            { "data": "Bonus" },
            { "data": "Potongan" },
            { "data": "Action" }
        ]
    });

    $('#create_settingan').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menghapus settingan untuk: " + nama,
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
                    url: 'controller/delete_settingan.php',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
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
                    error: function () {
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
