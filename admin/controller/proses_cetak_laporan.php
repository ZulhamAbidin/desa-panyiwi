<?php
ob_start();
require_once '../koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='../login.php'</script>";
    exit();
}

$id = $_SESSION['id'];
$ambil = mysqli_query($koneksi, "SELECT * FROM user WHERE id_admin = '$_SESSION[id]'");
$dt = mysqli_fetch_array($ambil);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="app sidebar-mini ltr light-mode">
    <div class="page">
        <div class="page-main">

            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar"
                            href="javascript:void(0)"></a>

                        <a class="logo-horizontal " href="">
                            <img src="../../sash/images/brand/logo.png" class="header-brand-img desktop-logo"
                                alt="logo">
                            <img src="../../sash/images/brand/logo-3.png" class="header-brand-img light-logo1"
                                alt="logo">
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
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold"><?= $dt['nama'] ?>
                                                        </h5>
                                                        <small class="text-muted">Admin</small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="data_admin.php">
                                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                                </a>
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="confirmLogout()">
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
                            <img src="../../sash/images/brand/logo.png" class="header-brand-img desktop-logo"
                                alt="logo">
                            <img src="../../sash/images/brand/logo-1.png" class="header-brand-img toggle-logo"
                                alt="logo">
                            <img src="../../sash/images/brand/logo-2.png" class="header-brand-img light-logo"
                                alt="logo">
                            <img src="../../sash/images/brand/logo-3.png" class="header-brand-img light-logo1"
                                alt="logo">
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
                                <a class="side-menu__item has-link" href="list.php"><i
                                        class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">List
                                        Data
                                        Keuangan</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="tambah.php"><i
                                        class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Tambah
                                        Data Keuangan</span></a>
                            </li>

                            <li class="sub-category">
                                <h3>Kategori</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="kategori_list.php"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Kategori
                                        List</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="kategori_tambah.php"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Kategori
                                        Tambah</span></a>
                            </li>

                            <li class="sub-category">
                                <h3>Cetak</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="cetak_list.php"><i
                                        class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">Cetak
                                        Laporan</span></a>
                            </li>


                            <!-- <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Pengelolaan Keuangan</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="" class="slide-item"> x</a></li>
                                    <li><a href="" class="slide-item"> x</a></li>
                                    <li><a href="" class="slide-item"> x</a></li>
                                </ul>
                            </li> -->

                            <li class="sub-category">
                                <h3>Lainya</h3>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="data_admin.php"><i
                                        class="side-menu__icon fe fe-settings"></i><span
                                        class="side-menu__label">Pengaturan</span></a>
                            </li>

                            <li>
                                <a class="side-menu__item has-link" href="#" onclick="confirmLogout()"><i
                                        class="side-menu__icon fe fe-toggle-left"></i><span
                                        class="side-menu__label">Logout</span></a>
                            </li>
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg></div>
                    </div>
                </div>
            </div>
            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid">

                        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                            <div id="toastSuccess" class="toast hide" role="alert" aria-live="assertive"
                                aria-atomic="true">
                                <div class="toast-header bg-primary text-white">
                                    <strong class="me-auto">Berhasil!</strong>
                                    <button type="button" class="btn-close text-white btn-primay"
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <!-- Tempat untuk menampilkan pesan sukses -->
                                </div>
                            </div>
                            <div id="toastError" class="toast hide" role="alert" aria-live="assertive"
                                aria-atomic="true">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="me-auto">Kesalahan!</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <!-- Tempat untuk menampilkan pesan kesalahan -->
                                </div>
                            </div>
                        </div>


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

                            <?php
                                include '../koneksi.php';

                                // Fungsi untuk mendapatkan data laporan berdasarkan kategori dan rentang tanggal
                                function getLaporan($koneksi, $kategori, $start_date, $end_date)
                                {
                                    $kategori_ids = implode(',', $kategori); // Menggabungkan array kategori menjadi string untuk query
                                    
                                    // Query untuk mengambil data laporan berdasarkan kategori yang dipilih dan rentang tanggal
                                    $query = "SELECT lk.*, l.nama_kategori 
                                            FROM laporan_keuangan lk
                                            INNER JOIN laporan_kategori lk_cat ON lk.id = lk_cat.laporan_id
                                            INNER JOIN kategori l ON lk_cat.kategori_id = l.id
                                            WHERE lk_cat.kategori_id IN ($kategori_ids)
                                            AND lk.periode BETWEEN '$start_date' AND '$end_date'";
                                    
                                    $result = $koneksi->query($query);

                                    if ($result) {
                                        return $result->fetch_all(MYSQLI_ASSOC);
                                    } else {
                                        return null;
                                    }
                                }

                                // Ambil data dari parameter URL
                                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kategori']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                    // Ambil data dari URL
                                    $kategori_ids = explode(',', $_GET['kategori']);
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];
                                ?>



                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card">
                                        <div class="card-body">


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a class="header-brand" href="">
                                                        <img src="../../sash/images/brand/logo-3.png"
                                                            class="header-brand-img logo-3" alt="Sash logo">
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

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">U R A I A N</th>
                                                            <th class="text-center">Ref.</th>
                                                            <th class="text-center">ANGGARAN (Rp)</th>
                                                            <th class="text-center">REALISASI (Rp)</th>
                                                            <th class="text-center">LEBIH/(KURANG) (Rp)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
$total_anggaran = 0;
$total_realisasi = 0;

foreach ($kategori_ids as $kategori_id) {
    $laporan = getLaporan($koneksi, [$kategori_id], $start_date, $end_date);
    $query_kategori = "SELECT nama_kategori FROM kategori WHERE id = $kategori_id";
    $result_kategori = $koneksi->query($query_kategori);
    $nama_kategori = $result_kategori->fetch_assoc()['nama_kategori'];

    if ($laporan) {
        foreach ($laporan as $data) {
            $total_anggaran += $data['anggaran'];
            $total_realisasi += $data['realisasi'];
?>
            <tr>
                <td><span class="fw-semibold">
                        Kategori: <?php echo htmlspecialchars($nama_kategori); ?>
                    </span><br>
                    <span class="ms-6">
                        <?php echo htmlspecialchars($data['uraian']); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($data['ref']); ?></td>
                <td class="text-right">
                    <?php echo number_format($data['anggaran'], 2, ',', '.'); ?>
                </td>
                <td class="text-right">
                    <?php echo number_format($data['realisasi'], 2, ',', '.'); ?>
                </td>
                <td class="text-right">
                    <?php echo number_format($data['realisasi'] - $data['anggaran'], 2, ',', '.'); ?>
                </td>
            </tr>
<?php
        }
    }
}
?>
<tr>
    <td class="text-center" colspan="2"><strong>JUMLAH</strong></td>
    <td class="text-right"><?php echo number_format($total_anggaran, 2, ',', '.'); ?></td>
    <td class="text-right"><?php echo number_format($total_realisasi, 2, ',', '.'); ?></td>
    <td class="text-right">
        <strong><?php echo number_format($total_realisasi - $total_anggaran, 2, ',', '.'); ?></strong>
    </td>
</tr>

                                                    </tbody>

                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } else { ?>
                            <div class="alert alert-danger" role="alert">
                                Terjadi kesalahan: Data tidak lengkap atau tidak valid.
                            </div>
                            <?php } ?>

                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            // Script untuk mengatur format waktu sekarang
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
                                $('#now').text(formattedDate);
                            });
                        </script>

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
        $(function() {
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
</body>

</html>
