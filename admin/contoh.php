

<?php include 'src/header.php'; ?>

<div class="container">

    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <style>
            .text-turun {
                max-width: 400px !important;
                white-space: normal !important;
                word-break: break-word !important;
                overflow-wrap: break-word !important;
            }
        </style>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <a class="header-brand" href="index.html">
                                <img src="../sash/images/brand/logo-3.png" class="header-brand-img logo-3"
                                    alt="Sash logo">
                            </a>
                            <div>
                                <address class="pt-3">
                                    Pemerintah Desa Panyiwi<br>
                                    Kecamatan Cendrana, Kabupaten Bone
                                </address>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end border-bottom border-lg-0">
                            <h5 id="now"></h5>
                            <p>Start Date : </p>
                            <p>End Date : </p>
                        </div>
                    </div>
                    <div class="table-responsive push">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <tbody>
                                <tr class=" ">
                                    <th class="text-center"></th>
                                    <th>Uraian Atau Keterangan</th>
                                    <th class="text-center">Ref</th>
                                    <th class="text-end">Anggaran (Rp)</th>
                                    <th class="text-end">Realisasi (Rp)</th>
                                    <th class="text-end">Lebih Kurang (Rp)</th>
                                </tr>

                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <p class="font-w600 mb-1" width="50px">Nama Kategori 1</p>
                                        <div class="text-muted">
                                            <div class="text-muted text-turun ">Lorem ipsum dolor sit amet consectetur
                                                adipisicing elit. Ab quisquam soluta quasi fuga odio nulla, odit
                                                quibusdam aut atque consequuntur ratione explicabo quae reprehenderit?
                                                Placeat officia ullam vero aperiam. Doloremque.</div>
                                        </div>
                                    </td>
                                    <td class="text-center">xxxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>
                                        <p class="font-w600 mb-1" width="50px">Nama Kategori 2</p>
                                        <div class="text-muted">
                                            <div class="text-muted text-turun ">Lorem ipsum dolor sit amet consectetur
                                                adipisicing elit. Ab quisquam soluta quasi fuga odio nulla, odit
                                                quibusdam aut atque consequuntur ratione explicabo quae reprehenderit?
                                                Placeat officia ullam vero aperiam. Doloremque.</div>
                                        </div>
                                    </td>
                                    <td class="text-center">xxxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                    <td class="text-end">Rp. xxx.xxx</td>
                                </tr>

                                <tr>
                                    <td class="text-start ps-6 fw-semibold" colspan="3">TOTAL</td>
                                    <!-- Total Dari Keseluruhan Anggaran Jika terdapat "-" maka adalah kurang  -->
                                    <td class="text-end">Rp. xxx.xxx</td>

                                    <!-- Total Dari Keseluruhan Realisasi Jika terdapat "-" maka adalah kurang  -->
                                    <td class="text-end">Rp. xxx.xxx</td>

                                    <!-- Total Dari Keseluruhan Selisih Jika terdapat "-" maka adalah kurang  -->
                                    <td class="text-end">Rp. xxx.xxx</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <script>
                        var date = new Date();

                        function getNamaHari(hari) {
                            var namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                            return namaHari[hari];
                        }

                        function getNamaBulan(bulan) {
                            var namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                            ];
                            return namaBulan[bulan];
                        }

                        function tambahkanNol(angka) {
                            return angka < 10 ? '0' + angka : angka;
                        }

                        var hari = getNamaHari(date.getDay());
                        var tanggal = date.getDate();
                        var bulan = getNamaBulan(date.getMonth());
                        var tahun = date.getFullYear();
                        var jam = tambahkanNol(date.getHours());
                        var menit = tambahkanNol(date.getMinutes());

                        var hasilFormat = hari + ' ' + tanggal + ' ' + bulan + ' ' + tahun + ', ' + jam + ':' + menit +
                            '';

                        document.getElementById("now").innerHTML = hasilFormat;
                    </script>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-primary mb-1" onclick="javascript:window.print();"><i
                            class="si si-printer"></i> Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include 'src/footer.php'; ?>