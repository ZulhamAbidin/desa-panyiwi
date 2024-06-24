<?php include 'src/header.php'; ?>

<div class="container">
      <div class="page-header">
        <h1 class="page-title">Pengaturan</h1>
        <div>
            <ol class="breadcrumb">
            <a href="admin_tambah.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Data Admin</a>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Data Admin</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Admin</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM user");

                        while ($data = mysqli_fetch_array($query)) {
                            $class = ($data['username'] == $dt['username']) ? '' : '';
                        ?>
                            <tr class="<?= $class ?>">
                                <td><?= $no++ ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td>
                                    <?= $data['username'] ?>
                                </td>
                                <td><?php
                                    if ($data['username'] == $dt['username']) {
                                        echo ' <button type="button" class="d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fe fe-activity me-2"></i>Sedang Anda Gunakan</button>';
                                    }
                                    ?>
                                    <a href="admin_edit.php?id_admin=<?= $data['id_admin']; ?>"><button type="button" class='d-sm-inline-block btn btn-sm btn-primary shadow-sm'><span aria-hidden="true"></span>Edit</button></a>
                                    <a href="#" onclick="hapusData(<?= $data['id_admin']; ?>)">
                                        <button type="button" class='d-sm-inline-block btn btn-sm btn-danger shadow-sm'>
                                            <span aria-hidden="true"></span>Hapus
                                        </button>
                                    </a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function hapusData(id_admin) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'admin_hapus.php',
                    type: 'POST',
                    data: { id_admin: id_admin },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        $('#example1').DataTable();
    });
</script>

<script>
    $(document).ready(function () {
        $('#example1').DataTable();
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<?php include 'src/footer.php'; ?>