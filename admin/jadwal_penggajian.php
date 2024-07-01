<?php include 'src/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Jadwal Penggajian</h1>
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
                alert('Pembayaran berhasil diproses!');
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses pembayaran.');
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
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">${item.nama}</h5>
                                <p class="card-text">Jabatan: ${item.jabatan}</p>
                                <p class="card-text">Nomor Telepon: ${item.nomor_telepon}</p>
                                <p class="card-text">Periode Pembayaran: ${item.periode_pembayaran}</p>
                                <p class="card-text">Nomor Identifikasi: ${item.nomor_identifikasi}</p>
                                <p class="card-text">Gaji Pokok: ${item.gaji_pokok}</p>
                                <p class="card-text">Tunjangan: ${item.tunjangan}</p>
                                <p class="card-text">Bonus: ${item.bonus}</p>
                                <p class="card-text">Potongan: ${item.potongan}</p>
                                <p class="card-text">Total Gaji: ${item.total_gaji}</p>
                                <p class="card-text">Tanggal Pembayaran Terakhir: ${item.tanggal_pembayaran}</p>
                                <p class="card-text">Tanggal Pembayaran Yang Akan Datang: ${item.pembayaran_yang_akan_datang}</p>
                                <button class="bayar-sekarang btn btn-primary btn-bayar"
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
<script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<?php include 'src/footer.php'; ?>
