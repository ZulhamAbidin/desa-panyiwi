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
    <h1 class="page-title">List Data Keuangan</h1>
    <div>
        <ol class="breadcrumb">
            <a href="tambah.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Data Keuangan</a>
        </ol>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="dataKeuangan" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Uraian</th>
                    <th>Ref</th>
                    <th>Anggaran</th>
                    <th>Realisasi</th>
                    <th>Selisih</th>
                    <th>Periode</th>
                    <th>Kategori</th>
                    <th>Action</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid">
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid mb-3">
                    <p id="modalDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        $('#dataKeuangan').on('click', '.view-image', function () {
            var imageSrc = $(this).data('image');
            var description = $(this).data('description');
            $('#modalImage').attr('src', 'gambar/' + imageSrc);
            $('#imageModal .modal-body p').text(description);
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#dataKeuangan').DataTable({
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "lengthMenu": [5, 10, 25, 50, 100],
            "pageLength": 10,
            "ajax": {
                "url": "controller/get-data.php",
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "No"
                },
                {
                    "data": "Uraian"
                },
                {
                    "data": "Ref"
                },
                {
                    "data": "Anggaran"
                },
                {
                    "data": "Realisasi"
                },
                {
                    "data": "Selisih"
                },
                {
                    "data": "Periode"
                },
                {
                    "data": "Kategori"
                },
                {
                    "data": "Action"
                },
                {
                    "data": "Gambar",
                    "render": function (data, type, row) {
                        return '<button type="button" class="btn btn-link view-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="' +
                            data + '" data-description="' + row['Deskripsi Gambar'] + '"><i class="bi bi-eye"></i></button>';
                    }
                }
            ]
        });

        $('#dataKeuangan').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            var uraian = $(this).data('uraian');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus data dengan uraian: " + uraian,
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
                        url: 'controller/delete_data.php',
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
                                    'Terjadi kesalahan saat menghapus data.',
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