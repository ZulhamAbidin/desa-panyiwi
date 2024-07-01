<?php include 'src/header.php'; 

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
    <h1 class="page-title">Jadwal Penggajian</h1>
</div>


<div class="container">

    halaman jadwal_penggajian.php
    jadi yang tampil dibawah ini hanya data yang ada pada tabel "gaji_otomatis"

    id, nama, jabatan nomor_identifikasi, email, nomor_telepon,	alamat,	periode_pembayaran	
        
    1, Zulham Abidin, Ketua Umum, 1929042004, zlhm378@gmail.com, 0895801138822, Gowa, triwulanan
    2, Annisa Septiani Kamal, Staf, 1929042000, AnnisaSeptianiKamal@gmail.com, 1929042000, Btn Nuki Dwi Karya Permai, bulanan

    <div class="row">
        <div class="col-sm-6 col-xl-3 col-md-6 col-lg-6">
            <div class="panel price panel-color">
                <div class="pb-4 px-5 border-bottom">
                    <h3 class="pb-2">"nama" ( kolom nama dari tabel pegawai)</h3>
                    <span>dibayarkan setiap <span class="fw-semibold">"periode_pembayaran"</span>, Jabatan Sebagai "jabatan", dengan no ponsel "no_telepon". ( data diambil dari tabel pegawai )</span>
                </div>
                <div class="panel-body p-0 ps-5">
                    <p class="lead py-0 text-primary"><strong>"total_gaji" ( diambil dari kolom total pada tabel gaji_pegawai)</strong></p>
                    <p><i class="fe fe-plus me-1">"periode_pembayaran" (diambil dari tabel pegawai)</i></p>
                </div>
                <div class="panel-footer text-center px-5 border-0 pt-0">
                    <a class="btn btn-block btn-primary btn-pill" href="javascript:void(0)">Bayarkan Sekarang!</a>

                    <!-- BACA DIBAWAH INI 
                    
                    button diatas akan otomatis melakukan pembayaran atau insert data ke tabel gaji_pegawai dengan kolom sebagai berikut
                    1   id Primary	
                    2	pegawai_id
                    3	periode
                    4	gaji_pokok	decimal(15,0)
                    5	tunjangan	decimal(15,0)
                    6	potongan	decimal(15,0)
                    7	bonus	decimal(15,0)
                    8	total_gaji	decimal(15,0)
                    9	tanggal_pembayaran
                    10	metode_pembayaran

                    datanya isinya diambil dari tabel gaji_otomatis yang berelasi 
                    dengan tabel pegawai berdasarkan kolom pegawai_id yang ada pada tabel gaji otomatis

                    tabel gaji_otomatis
                    id, pegawai_id, gaji_pokok, tunjangan, bonus, potongan

                    tabel pegawai
                    id,	nama, jabatan, nomor_identifikasi ,email, nomor_telepon, alamat, periode_pembayaran, -->

                </div>
                <ul class="list-group list-group-flush pb-5">
                    <li class="list-group-item border-0"><i
                            class="mdi mdi-circle-outline text-primary p-2 fs-12"></i><strong> Gaji Pokok</strong> "gaji_pokok" ( diambil dari tabel gaji_pegawai)
                    </li>
                    <li class="list-group-item border-0"><i
                            class="mdi mdi-circle-outline text-primary p-2 fs-12"></i><strong>Tunjangan </strong> "tunjangan" ( diambil dari tabel gaji_pegawai)
                    </li>
                    <li class="list-group-item border-0"><i
                            class="mdi mdi-circle-outline text-primary p-2 fs-12"></i><strong> Potongan </strong> "potongan" ( diambil dari tabel gaji_pegawai)
                    </li>
                    <li class="list-group-item border-0"><i
                            class="mdi mdi-circle-outline text-primary p-2 fs-12"></i><strong> Bonus </strong> "bonus" ( diambil dari tabel gaji_pegawai)
                    </li>
                    <li class="list-group-item border-bottom-0"><i
                            class="mdi mdi-circle-outline text-primary p-2 fs-12"></i><strong> 24/7</strong> "metode_pembayaran" ( diambil dari tabel gaji_pegawai)
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<?php include 'src/footer.php'; ?>
