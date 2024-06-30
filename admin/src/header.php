<?php
ob_start();
require_once '../koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='../login.php'</script>";
    exit();
}

$id     = $_SESSION['id'];
$ambil  = mysqli_query($koneksi, "SELECT * FROM user WHERE id_admin = '$_SESSION[id]'");
$dt     = mysqli_fetch_array($ambil);

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
    <link rel="shortcut icon" type="image/x-icon" href="../sash/images/brand/logo-2.png" />
    <title>Sisfo Keuangan Desa Panyiwi</title>
    <link id="style" href="../sash/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../sash/css/style.css" rel="stylesheet" />
    <link href="../sash/css/dark-style.css" rel="stylesheet" />
    <link href="../sash/css/transparent-style.css" rel="stylesheet">
    <link href="../sash/css/skin-modes.css" rel="stylesheet" />
    <link href="../sash/css/icons.css" rel="stylesheet" />
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="../sash/colors/color1.css" />
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
                            <img src="../sash/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../sash/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
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
                                            <button class="btn btn-sm btn-primary" id="date"></button>
                                        </div>

                                        <script>
                                            var tw = new Date();
                                            if (tw.getTimezoneOffset() == 0)(a = tw.getTime() + (7 * 60 * 60 * 1000))
                                            else(a = tw.getTime());
                                            tw.setTime(a);
                                            var tahun = tw.getFullYear();
                                            var hari = tw.getDay();
                                            var bulan = tw.getMonth();
                                            var tanggal = tw.getDate();
                                            var hariarray = new Array("Minggu,", "Senin,", "Selasa,", "Rabu,", "Kamis,", "Jum'at,", "Sabtu,");
                                            var bulanarray = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember",  "Desember");
                                            document.getElementById("date").innerHTML = hariarray[hari] + " " +  tanggal + " " + bulanarray[bulan] + " " + tahun;
                                        </script>

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
                                                <img src="../sash/images/brand/logo-2.png" alt="profile-user"
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
                            <img src="../sash/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="../sash/images/brand/logo-1.png" class="header-brand-img toggle-logo" alt="logo">
                            <img src="../sash/images/brand/logo-2.png" class="header-brand-img light-logo" alt="logo">
                            <img src="../sash/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
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
                                <h3>Penggajian</h3>
                            </li>


                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Penggajian</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="list_gaji.php" class="slide-item">List Data Penggajian</a></li>
                                    <li><a href="create_gaji.php" class="slide-item">Tambah Data Penggajian</a></li>
                                    <li><a href="list_settingan.php" class="slide-item"> List Komponen Penggajian</a>
                                    </li>
                                    <li><a href="create_settingan.php" class="slide-item"> Tambah Komponen
                                            Penggajian</a></li>
                                </ul>
                            </li>

                            <li class="sub-category">
                                <h3>Kepegawaian</h3>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Kepegawaian</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="list_pegawai.php" class="slide-item"> List Data Kepegawaian</a></li>
                                    <li><a href="create_pegawai.php" class="slide-item"> Tambah Data Kepegawaian</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sub-category">
                                <h3>Operasional</h3>
                            </li>

                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-slack"></i><span
                                        class="side-menu__label">Operasional</span><i
                                        class="angle fe fe-chevron-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="tambah.php" class="slide-item"> Tambah Data Operasional</a></li>
                                    <li><a href="list.php" class="slide-item"> List Data Operasional</a></li>

                                    <li><a href="kategori_tambah.php" class="slide-item">Tambah Kategori Operasional</a>
                                    </li>
                                    <li><a href="kategori_list.php" class="slide-item">List Kategori Operasional</a>
                                    </li>

                                    <li><a href="cetak_list.php" class="slide-item"> Cetak Laporan Operasional</a></li>
                                </ul>
                            </li>

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
