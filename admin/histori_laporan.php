<?php include 'src/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Histori Laporan</h1>
</div>

<div class="container">
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Histori Export Laporan Penggajian</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal Export</th>
                            <th>Waktu Export</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header with-border">
            <h3 class="card-title">Histori Distribusi Slip Gaji</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="slipgaji" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>Email Tujuan</th>
                            <th>Tanggal Export</th>
                            <th>Waktu Export</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
    var table = $('#slipgaji').DataTable({
        "ajax": {
            "url": "controller/fetch_histori_slip_gaji.php",
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            {
                "data": null,
                "defaultContent": "",
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "nama_pegawai" },
            { "data": "email_pegawai" },
            {
                "data": "tanggal_export",
                "render": function(data, type, row) {
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return new Date(data).toLocaleDateString('id-ID', options);
                }
            },
            {
                "data": "waktu_export",
                "render": function(data, type, row) {
                    var [hours, minutes] = data.split(':');
                    return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
                }
            },
            {
                "data": "file_path",
                "render": function(data, type, row) {
                    var fileName = data.split('/').pop();
                    return `
                        <a href="export_pdf/${data}" class="btn btn-primary btn-sm" download>Download</a>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    $('#slipgaji').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus slip gaji ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controller/delete_histori_slip_gaji.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Slip gaji berhasil dihapus.',
                                'success'
                            );
                            table.ajax.reload(); // Reload data tabel
                        } else {
                            Swal.fire(
                                'Gagal!',
                                jsonResponse.error || 'Slip gaji gagal dihapus.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });
});
</script>


<script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
            "ajax": {
                "url": "controller/fetch_histori_laporan.php",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [{
                    "data": null,
                    "defaultContent": "",
                    "className": "text-center",
                    "render": function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "nama_pegawai",
                    "className": "text-center"
                },
                {
                    "data": "tanggal_export",
                    "render": function (data, type, row) {
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        return new Date(data).toLocaleDateString('id-ID', options);
                    },
                    "className": "text-center"
                },
                {
                    "data": "waktu_export",
                    "render": function (data, type, row) {
                        var [hours, minutes] = data.split(':');
                        return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "file_path",
                    "render": function (data, type, row) {
                        var fileName = data.split('/').pop();
                        return `
                        <a href="export_pdf/${data}" class="btn btn-primary btn-sm" download>Download</a>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Delete</button>
                    `;
                    },
                    "className": "text-center"
                }
            ]
        });

        $('#table').on('click', '.btn-delete', function () {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus laporan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/delete_histori_laporan.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function (response) {
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                                table.ajax.reload(); // Reload data tabel
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    jsonResponse.error || 'Data gagal dihapus.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });

    });
</script>

<?php include 'src/footer.php'; ?>