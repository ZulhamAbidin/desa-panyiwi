<?php include 'src/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Jadwal Penggajian Di Masa Mendatang</h1>
</div>

<div class="container mt-5">
    <div class="row" id="card-container">
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#card-container').on('click', '.bayar-sekarang', function () {
            const pegawaiId = $(this).data('pegawai_id');
            const pembayaranYangAkanDatang = $(this).data('pembayaran_yang_akan_datang');
            const gajiPokok = $(this).data('gaji_pokok');
            const tunjangan = $(this).data('tunjangan');
            const potongan = $(this).data('potongan');
            const bonus = $(this).data('bonus');
            const totalGaji = $(this).data('total_gaji');
            const tanggalPembayaran = $(this).data('tanggal_pembayaran');
            const metodePembayaran = $(this).data('metode_pembayaran');

            Swal.fire({
                title: '<h4>Upload Bukti Pembayaran</h4>',
                html: `
                    <form id="formPembayaran" enctype="multipart/form-data">
                        <input type="file" id="uploadBuktiPembayaran" class="form-control form-control-sm form-control-file" name="upload_gambar">
                        <input type="hidden" name="pegawai_id" value="${pegawaiId}">
                        <input type="hidden" name="pembayaran_yang_akan_datang" value="${pembayaranYangAkanDatang}">
                        <input type="hidden" name="gaji_pokok" value="${gajiPokok}">
                        <input type="hidden" name="tunjangan" value="${tunjangan}">
                        <input type="hidden" name="potongan" value="${potongan}">
                        <input type="hidden" name="bonus" value="${bonus}">
                        <input type="hidden" name="total_gaji" value="${totalGaji}">
                        <input type="hidden" name="tanggal_pembayaran" value="${tanggalPembayaran}">
                        <input type="hidden" name="metode_pembayaran" value="${metodePembayaran}">
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Unggah',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const formData = new FormData($('#formPembayaran')[0]);
                    return $.ajax({
                        url: 'controller/proses_pembayaran.php',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log('Response:', response);
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Bukti pembayaran berhasil diunggah.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat mengunggah bukti pembayaran.',
                                'error'
                            );
                        }
                    });
                }
            });

        });

        $.ajax({
            url: 'controller/fetch_jadwal_penggajian.php',
            method: 'GET',
            success: function (response) {
                console.log('Response:', response);
                try {
                    const data = response.data;
                    console.log('Parsed Data:', data);
                    data.forEach(item => {
                        let periodePembayaranText;
                        switch (item.periode_pembayaran) {
                            case 'bulanan':
                                periodePembayaranText = 'Setiap Bulan';
                                break;
                            case 'triwulanan':
                                periodePembayaranText = 'Setiap 3 Bulan';
                                break;
                            case 'tahunan':
                                periodePembayaranText = 'Setiap Tahun';
                                break;
                        }
                        const card = `
                            <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4">
                                <div class="panel price panel-color bg-primary-transparent">
                                    <div class="pb-4 px-5 border-bottom bg-white">
                                        <h4 class="align-middle text-center pt-6 fw-bold">${item.nama}</h4>
                                        <p class="pb-1 fs-12 align-middle text-center">${item.jabatan}</p>
                                        <p class="fs-12 text-center align-middle">Dibayarkan setiap <span class="fw-bold">${periodePembayaranText}</span>, dengan no ponsel ${item.nomor_telepon}.</p>
                                    </div>
                                    <div class="panel-body p-0">
                                        <div class="text-center py-2 fw-bold text-primary align-middle fs-25">${item.total_gaji}</div>
                                    </div>
                                    <div class="panel-footer text-center px-5 border-0 pt-0">
                                        <button class="bayar-sekarang btn btn-block btn-primary btn-pill btn-bayar"
                                            data-pegawai_id="${item.pegawai_id}"
                                            data-pembayaran_yang_akan_datang="${item.pembayaran_yang_akan_datang}"
                                            data-gaji_pokok="${item.gaji_pokok.replace('Rp ', '').replace(/\./g, '')}"
                                            data-tunjangan="${item.tunjangan.replace('Rp ', '').replace(/\./g, '')}"
                                            data-potongan="${item.potongan.replace('Rp ', '').replace(/\./g, '')}"
                                            data-bonus="${item.bonus.replace('Rp ', '').replace(/\./g, '')}"
                                            data-total_gaji="${item.total_gaji.replace('Rp ', '').replace(/\./g, '')}"
                                            data-tanggal_pembayaran="${item.tanggal_pembayaran}"
                                            data-metode_pembayaran="Gopay">Bayar Sekarang</button>
                                    </div>
                                    <ul class="list-group list-group-flush pb-2">
                                        <li class="list-group-item border-0">
                                            <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Gaji Pokok</strong> ${item.gaji_pokok}
                                        </li>
                                        <li class="list-group-item border-0">
                                            <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Tunjangan </strong> ${item.tunjangan}
                                        </li>
                                        <li class="list-group-item border-0">
                                            <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Potongan </strong> ${item.potongan}
                                        </li>
                                        <li class="list-group-item border-0">
                                            <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Bonus </strong> ${item.bonus}
                                        </li>
                                    </ul>
                                    <div class="pb-4 px-5 border-top pt-4 fw-semibold">
                                        <p class="text-center align-middle">Tanggal Terakhir Kali Gaji Dibayarkan ${item.tanggal_pembayaran}</p>
                                        <p class="text-center align-middle">Gaji Berikutnya ${item.pembayaran_yang_akan_datang}</p>
                                    </div>
                                </div>
                            </div>`;
                        $('#card-container').append(card);
                    });
                } catch (error) {
                    console.error('JSON parse error:', error);
                    alert('Terjadi kesalahan dalam parsing data.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data penggajian.');
            }
        });
    });
</script>

<?php include 'src/footer.php'; ?>