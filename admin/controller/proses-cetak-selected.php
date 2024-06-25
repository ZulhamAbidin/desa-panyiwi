<?php
include '../koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $selected_ids = $_POST['selected_ids'];
    $ids = implode(',', array_map('intval', $selected_ids));

    $query = "
        SELECT lk.id, lk.uraian, lk.ref, lk.anggaran, lk.realisasi, lk.selisih, lk.periode, k.nama_kategori 
        FROM laporan_keuangan lk
        LEFT JOIN laporan_kategori lkat ON lk.id = lkat.laporan_id
        LEFT JOIN kategori k ON lkat.kategori_id = k.id
        WHERE lk.id IN ($ids)
    ";
    $result = $koneksi->query($query);

    if ($result === false) {
        die("Query error: " . $koneksi->error);
    }

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row; 
    }

    if (!empty($rows)) {
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../../sash/images/brand/logo-2.png" />
    <title>Sisfo Keuangan Desa Panyiwi</title>
    <link id="style" href="../../sash/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../sash/css/style.css" rel="stylesheet" />
    <link href="../../sash/css/dark-style.css" rel="stylesheet" />
    <link href="../../sash/css/transparent-style.css" rel="stylesheet">
    <link href="../../sash/css/skin-modes.css" rel="stylesheet" />
    <link href="../../sash/css/icons.css" rel="stylesheet" />
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="../../sash/colors/color1.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media print {
            body {
                margin-top: 150px !important;
                padding: 0;
                color: black !important;
            }
            
            .xxx {
                color: black !important;
            }

            .cetak {
                margin: 0;
                padding: 10px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .btn {
                display: none;
            }

            .hidden-cetak {
                display: none;
            }
        }
    </style>
</head>
<body class="app sidebar-mini ltr light-mode">
    <div class="page">
        <div class="page-main">

            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        
                        <a class="logo-horizontal " href="">
                            <img src="../../sash/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../../sash/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
                        </a>
                        
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <div class="dropdown d-lg-none d-flex">
                                            <a href="javascript:void(0)" class="nav-link icon"
                                                data-bs-toggle="dropdown">
                                                <i class="fe fe-search"></i>
                                            </a>
                                            <div class="dropdown-menu header-search dropdown-menu-start">
                                                <div class="input-group w-100 p-2">
                                                    <input type="text" class="form-control" placeholder="Search....">
                                                    <div class="input-group-text btn btn-primary">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex country">
                                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                                            </a>
                                        </div>

                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i class="fe fe-minimize fullscreen-button"></i>
                                            </a>
                                        </div>
                                       
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                                class="nav-link leading-none d-flex">
                                                <img src="../../sash/images/brand/logo-2.png" alt="profile-user"
                                                    class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold"><?= $dt['nama'] ?></h5>
                                                        <small class="text-muted">Admin</small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="data_admin.php">
                                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                                </a>
                                                </a>
                                                <a class="dropdown-item" href="#"  onclick="confirmLogout()" >
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="">
                            <img src="../../sash/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../../sash/images/brand/logo-1.png" class="header-brand-img toggle-logo" alt="logo">
                            <img src="../../sash/images/brand/logo-2.png" class="header-brand-img light-logo" alt="logo">
                            <img src="../../sash/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
                        </a>
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg></div>
                        <ul class="side-menu">
                            <li class="sub-category">
                                <h3>Main</h3>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item has-link" data-bs-toggle="slide" href="index.php"><i
                                        class="side-menu__icon fe fe-home"></i><span
                                        class="side-menu__label">Dashboard</span></a>
                            </li>

                            <li class="sub-category">
                                <h3>Keuangan</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../list.php"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">List Data Keuangan</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../tambah.php"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Tambah Data Keuangan</span></a>
                            </li>

                            <li class="sub-category">
                                <h3>Kategori</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../kategori_list.php"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Kategori List</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../kategori_tambah.php"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Kategori Tambah</span></a>
                            </li>

                            <li class="sub-category">
                                <h3>Cetak</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../cetak_list.php"><i class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Cetak Laporan</span></a>
                            </li>

                            
                            <!-- <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="../javascript:void(0)"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Pengelolaan Keuangan</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="../" class="slide-item"> x</a></li>
                                    <li><a href="../" class="slide-item"> x</a></li>
                                    <li><a href="../" class="slide-item"> x</a></li>
                                </ul>
                            </li> -->

                            <li class="sub-category">
                                <h3>Lainya</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="../data_admin.php"><i class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">Pengaturan</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="#"  onclick="confirmLogout()" ><i class="side-menu__icon fe fe-toggle-left"></i><span class="side-menu__label">Logout</span></a>
                            </li>                            
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg></div>
                    </div>
                </div>
            </div>

            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid">

                        <div class="container">
                            <div class="page-header">
                                <h1 class="page-title">Cetak</h1>
                                <div>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Cetak</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row cetak">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                
                                                <table class="table table-bordered table-hover mb-0 text-nowrap">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <a class="header-brand" href="">
                                                            <img src="../../sash/images/brand/logo-3.png" class="header-brand-img logo-3" alt="Sash logo">
                                                        </a>
                                                        <div>
                                                            <address class="pt-3">
                                                                Pemerintah Desa Panyiwi<br>
                                                                Kecamatan Cendrana, Kabupaten Bone
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 text-end border-bottom border-lg-0 hidden-cetak">
                                                        <address id="now"></address>
                                                        <address class="pt-6">
                                                            
                                                        </address>
                                                    </div>
                                                </div>
                                                    <thead>
                                                        <tr class="bg-primary xxx">
                                                            <th class="text-center text-white">Uraian</th>
                                                            <th class="text-center text-white">Ref</th>
                                                            <th class="text-center text-white">Anggaran</th>
                                                            <th class="text-center text-white">Realisasi</th>
                                                            <th class="text-center text-white">Selisih</th>
                                                            <th class="text-center text-white">Periode</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php 
                                                            $total_anggaran = 0;
                                                            $total_realisasi = 0;
                                                            $total_selisih = 0;
                                                            
                                                            foreach ($rows as $row): 
                                                                $total_anggaran += $row['anggaran'];
                                                                $total_realisasi += $row['realisasi'];
                                                                $total_selisih += $row['selisih'];
                                                            ?>
                                                            <tr>
                                                                <td class=""><span class="fw-semibold" >
                                                                    <!-- Kategori:  -->
                                                                    <?= htmlspecialchars($row['nama_kategori']) ?>
                                                                    </span><br><br>
                                                                    <span class="ms-6"><?= htmlspecialchars($row['uraian']) ?></span></td>
                                                                <td class="text-center align-middle"><?= htmlspecialchars($row['ref']) ?></td>
                                                                <td class="text-center align-middle"><?= 'Rp. ' . number_format($row['anggaran'], 0, ',', '.') ?></td>
                                                                <td class="text-center align-middle"><?= 'Rp. ' . number_format($row['realisasi'], 0, ',', '.') ?></td>
                                                                <td class="text-center align-middle"><?= 'Rp. ' . number_format($row['selisih'], 0, ',', '.') ?></td>
                                                                <td class="text-center align-middle"><?= htmlspecialchars($row['periode']) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        <tr>
                                                            <td class="text-center" colspan="3"><strong>JUMLAH</strong></td>
                                                            <td class="text-center align-middle"><?= 'Rp. ' . number_format($total_anggaran, 0, ',', '.') ?></td>
                                                            <td class="text-center align-middle"><?= 'Rp. ' . number_format($total_realisasi, 0, ',', '.') ?></td>
                                                            <td class="text-center align-middle"><?= 'Rp. ' . number_format($total_selisih, 0, ',', '.') ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a href="../cetak_list.php" class="btn btn-primary"><i class="si si-arrow-left pe-2"></i>Kembali</a>
                                            <button type="button" class="btn btn-primary" onclick="printDiv();"><i class="si si-printer pe-2"></i>Cetak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                                } else {
                                    echo "<div class='container'><p>Tidak ada data yang dipilih.</p></div>";
                                }
                            } else {
                                echo "<div class='container'><p>Tidak ada data yang dipilih.</p></div>";
                            }?>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © <span id="year"></span> <a href="javascript:void(0)">Keuangan</a> All
                        rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable()
            $('#example3').DataTable()
            $('#example4').DataTable()
            $('#example5').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        }

    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <!-- MULTI SELECT JS-->
    
    <script src="../../sash/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../../sash/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../../sash/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="../../sash/plugins/datatable/js/jszip.min.js"></script>
    <script src="../../sash/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="../../sash/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="../../sash/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="../../sash/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="../../sash/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="../../sash/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../../sash/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="../../sash/js/table-data.js"></script>
    <script src="../../sash/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../sash/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../sash/js/sticky.js"></script>
    <script src="../../sash/js/circle-progress.min.js"></script>
    <script src="../../sash/plugins/peitychart/peitychart.init.js"></script>
    <script src="../../sash/plugins/sidebar/sidebar.js"></script>
    <script src="../../sash/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../../sash/plugins/p-scroll/pscroll.js"></script>
    <script src="../../sash/plugins/p-scroll/pscroll-1.js"></script>
    <script src="../../sash/plugins/chart/Chart.bundle.js"></script>
    <script src="../../sash/plugins/chart/rounded-barchart.js"></script>
    <script src="../../sash/plugins/chart/utils.js"></script>

    <!-- <script src="../../sash/plugins/select2/select2.full.min.js"></script> -->
    
    <script src="../../sash/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../../sash/js/apexcharts.js"></script>
    <script src="../../sash/plugins/apexchart/irregular-data-series.js"></script>
    <script src="../../sash/plugins/flot/chart.flot.sampledata.js"></script>
    <script src="../../sash/plugins/sidemenu/sidemenu.js"></script>

    <script src="../../sash/plugins/bootstrap5-typehead/autocomplete.js"></script>
    <script src="../../sash/js/typehead.js"></script>
    <script src="../../sash/js/index1.js"></script>

    <script src="../../sash/js/themeColors.js"></script>
    <script src="../../sash/js/custom.js"></script>
    <script src="../../sash/js/circle-progress.min.js"></script>
    <script src="../../sash/plugins/peitychart/peitychart.init.js"></script>

    <script>
       $(document).ready(function() {
            var date = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            var formattedDate = date.toLocaleDateString('id-ID', options);
            $('#now').append(' Dicetak Pada: ' + formattedDate);
        });

        function printDiv() {
            var printContents = document.querySelector('.cetak').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
