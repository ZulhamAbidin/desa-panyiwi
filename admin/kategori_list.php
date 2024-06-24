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
    <h1 class="page-title">List Kategori</h1>
    <div>
        <ol class="breadcrumb">
            <a href="kategori_tambah.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Kategori</a>
        </ol>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="dataKategori" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#dataKategori').DataTable({
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "lengthMenu": [5, 10, 25, 50, 100],
            "pageLength": 10,
            "ajax": {
                "url": "controller/get-kategori.php",
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "No"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "Action"
                }
            ]
        });

        $('#dataKategori').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            var uraian = $(this).data('uraian');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus data dengan kategori: " + uraian,
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
                        url: 'controller/delete_kategori.php',
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
                                    'Ops..',
                                    'Tidak Diperbolehkan Mengapus Kategori, Karena Kategori Sedang Di Gunakan Pada Data Keuangan.',
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Ops..',
                                'Tidak Diperbolehkan Mengapus Kategori, Karena Kategori Sedang Di Gunakan Pada Data Keuangan.',
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