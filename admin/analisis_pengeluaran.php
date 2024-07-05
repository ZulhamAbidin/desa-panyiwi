<?php include 'src/header.php'; ?>

<style>
    #tabelGajiPegawai {
        display: none;
    }
</style>


<div class="container">
    <div class="page-header">
        <h1 class="page-title">Analisis Pengeluaran Gaji Pegawai</h1>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="mb-4 text-center fw-bold">Analisis Pengeluaran Gaji Pegawai</div>
            <div class="mb-4 text-center fw-semibold text-primary">Agar analisis berjalan dengan baik,
                pastikan untuk menambahkan data komponen penggajian untuk semua pegawai dan lakukan penggajian
                setidaknya untuk pertama kali.</div>
            <div class="text-center">
                <a href="create_settingan.php" class="btn btn-primary">Tambah Komponen Penggajian</a>
                <a href="create_gaji.php" class="btn btn-primary">Tambah Data Penggajian</a>
            </div>
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

            <div class="mb-3 mt-5">
                <h3 class="fw-bold text-center" id="totalGajiKeseluruhan"></h3>
                <p class="fw-semibold text-center" id="rentangWaktu"></p>
            </div>

            <table id="tabelGajiPegawai" class="table data-table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Gaji</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

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
        $('#formRentangWaktu').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'controller/proses.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    var data = response.data;
                    var totalGajiKeseluruhan = response.total_gaji_keseluruhan;
                    var tanggalMulai = response.tanggal_mulai;
                    var tanggalAkhir = response.tanggal_akhir;

                    var formattedTanggalMulai = formatTanggalIndonesia(tanggalMulai);
                    var formattedTanggalAkhir = formatTanggalIndonesia(tanggalAkhir);

                    $('#rentangWaktu').text('Rentang Waktu: ' + formattedTanggalMulai +
                        ' sampai ' + formattedTanggalAkhir);

                    var table = $('#tabelGajiPegawai').DataTable({
                        destroy: true,
                        data: data,
                        columns: [{
                                data: 'nama',
                                render: function (data, type, row) {
                                    return 'Penggajian ' + data;
                                }
                            },
                            {
                                data: 'total_gaji',
                                render: function (data) {
                                    return 'Rp ' + new Intl.NumberFormat(
                                        'id-ID').format(data);
                                }
                            }
                        ],
                        "language": {
                            "decimal": "",
                            "emptyTable": "Tidak ada data yang tersedia",
                            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                            "infoFiltered": "(disaring dari _MAX_ total entri)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Tampilkan _MENU_ entri",
                            "loadingRecords": "Memuat...",
                            "processing": "Memproses...",
                            "search": "Cari:",
                            "zeroRecords": "Tidak ada hasil yang cocok ditemukan",
                            "paginate": {
                                "first": "Pertama",
                                "last": "Terakhir",
                                "next": "Selanjutnya",
                                "previous": "Sebelumnya"
                            },
                            "aria": {
                                "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                                "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                            }
                        }
                    });

                    $('#totalGajiKeseluruhan').html('Total Pengeluaran Dimasa Mendatang: ' +
                        new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(totalGajiKeseluruhan));

                    $('#tabelGajiPegawai').css('display', 'table');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memproses permintaan: ' +
                            error,
                    });
                }

            });
        });

        function formatTanggalIndonesia(dateString) {
            var options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            var tanggal = new Date(dateString);
            return tanggal.toLocaleDateString('id-ID', options);
        }
    });
</script>



<?php include 'src/footer.php'; ?>