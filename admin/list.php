<?php include 'src/header.php'; ?>

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
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT lk.id, lk.uraian, lk.ref, lk.anggaran, lk.realisasi, lk.selisih, lk.periode, k.nama_kategori
                          FROM laporan_keuangan lk
                          LEFT JOIN laporan_kategori lktr ON lk.id = lktr.laporan_id
                          LEFT JOIN kategori k ON lktr.kategori_id = k.id";
                $result = $koneksi->query($query);

                if ($result && $result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$row['uraian']}</td>";
                        echo "<td>{$row['ref']}</td>";
                        echo "<td>Rp. " . number_format($row['anggaran'], 0, ',', '.') . "</td>";
                        echo "<td>Rp. " . number_format($row['realisasi'], 0, ',', '.') . "</td>";
                        echo "<td>Rp. " . number_format($row['selisih'], 0, ',', '.') . "</td>";
                        echo "<td>{$row['periode']}</td>";
                        echo "<td>{$row['nama_kategori']}</td>";
                        echo "<td>
                                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id']}' data-uraian='{$row['uraian']}'>
                                    <i class='fe fe-trash me-1'></i>Delete
                                </button>
                              </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data keuangan tersedia</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
            "columns": [
                { "data": "No" },
                { "data": "Uraian" },
                { "data": "Ref" },
                { "data": "Anggaran" },
                { "data": "Realisasi" },
                { "data": "Selisih" },
                { "data": "Periode" },
                { "data": "Kategori" },
                { "data": "Action" }
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
                        data: { id: id },
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
