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
                title: 'Konfirmasi Pembayaran',
                text: "Apakah Anda yakin ingin memproses pembayaran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, bayar sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/proses_pembayaran.php',
                        method: 'POST',
                        data: {
                            pegawai_id: pegawaiId,
                            pembayaran_yang_akan_datang: pembayaranYangAkanDatang,
                            gaji_pokok: gajiPokok,
                            tunjangan: tunjangan,
                            potongan: potongan,
                            bonus: bonus,
                            total_gaji: totalGaji,
                            tanggal_pembayaran: tanggalPembayaran,
                            metode_pembayaran: metodePembayaran
                        },
                        success: function (response) {
                            console.log('Pembayaran berhasil diproses:', response);
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Pembayaran berhasil diproses!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Refresh the page
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat memproses pembayaran.',
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
                        const card = `
                    <div class="col-sm-6 col-xl-3 col-md-6 col-lg-4">
                        <div class="panel price panel-color bg-primary-transparent">
                            <div class="pb-4 px-5 border-bottom bg-white">
                                <h4 class="align-middle text-center pt-6 fw-bold">"${item.nama}"</h4>
                                <p class="pb-1 fs-12 align-middle text-center">"${item.jabatan}"</p>
                                <p class="fs-12 text-center align-middle">dibayarkan setiap <span class="fw-bold">"${item.periode_pembayaran}"</span>, dengan no ponsel "${item.nomor_telepon}".</p>
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
                                    <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Gaji Pokok</strong> 
                                    "${item.gaji_pokok}"
                                </li>                                    
                                <li class="list-group-item border-0">
                                    <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12">Tunjangan </strong> 
                                    "${item.tunjangan}"
                                </li>                                    
                                <li class="list-group-item border-0">
                                    <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Potongan </strong> 
                                    "${item.potongan}"
                                </li>                                    
                                <li class="list-group-item border-0">
                                    <i class="mdi mdi-circle-outline text-primary p-2 fs-11 text-center align-middle"></i><strong class="fw-12"> Bonus </strong> 
                                    "${item.bonus}"
                                </li> 
                            </ul>
                             <div class="pb-4 px-5 border-top pt-4 fw-semibold">
                                <p class="text-center align-middle">Tanggal Terakhir Kali Gaji Dibayarkan "${item.tanggal_pembayaran}"</p>
                                <p class="text-center align-middle">Gaji Berikutnya "${item.pembayaran_yang_akan_datang}" </p>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<?php include 'src/footer.php'; ?>
