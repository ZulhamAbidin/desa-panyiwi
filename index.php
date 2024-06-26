<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><link rel="shortcut icon" type="image/x-icon" href="sash/images/brand/logo-2.png" />
    <title>SIKUDES</title>
    <link id="style" href="sash/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="sash/css/style.css" rel="stylesheet" />
    <link href="sash/css/dark-style.css" rel="stylesheet" />
    <link href="sash/css/icons.css" rel="stylesheet" />
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="sash/colors/color1.css" />
    <style>
        .typed-cursor {
            display: none !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.10/typed.js"></script>
</head>

<body class="app ltr landing-page horizontal">


    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="hor-header header">
                <div class="container main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar"
                            href="javascript:void(0)"></a>
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal " href="">
                            <img src="sash/images/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                            <img src="sash/images/brand/logo-3.png" class="header-brand-img light-logo1" alt="logo">
                        </a>

                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse bg-white px-0" id="navbarSupportedContent-4">
                                    <div class="header-nav-right p-5">
                                        <a href="login.php" class="btn ripple btn-min w-sm btn-primary me-2 my-auto"><i
                                                class="fe fe-lock me-2"></i>Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-top-header overflow-hidden">
                <div class="top sticky overflow-hidden">
                    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                    <div class="app-sidebar bg-transparent horizontal-main">
                        <div class="container">
                            <div class="row">
                                <div class="main-sidemenu navbar px-0">
                                    <a class="navbar-brand ps-0 d-none d-lg-block" href="">
                                        <img alt="" class="logo-2" src="sash/images/brand/logo-3.png">
                                        <img src="sash/images/brand/logo.png" class="logo-3" alt="logo">
                                    </a>
                                    <ul class="side-menu">
                                        <li class="slide">
                                            <a class="side-menu__item active" data-bs-toggle="slide"
                                                href="#home"><span class="side-menu__label">Home</span></a>
                                        </li>
                                        <li class="slide">
                                            <a class="side-menu__item" data-bs-toggle="slide" href="#Features"><span
                                                    class="side-menu__label">Fitur</span></a>
                                        </li>
                                        <li class="slide">
                                            <a class="side-menu__item" data-bs-toggle="slide" href="#About"><span
                                                    class="side-menu__label">Tentang Kami</span></a>
                                        </li>
                                    </ul>
                                    <div class="header-nav-right d-none d-lg-flex">
                                        <a href="login.php"
                                            class="btn ripple btn-min w-sm btn-primary me-2 my-auto d-lg-none d-xl-block d-block"><i
                                                class="fe fe-lock me-2"></i>Login
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/APP-SIDEBAR-->
                </div>
                <div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal"
                    id="home">
                    <div class="container px-sm-0">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 mb-5 pb-5 animation-zidex pos-relative">


                                <h1 id="typed-output"
                                    class="mt-6 mt-md-0 typed-output text-primary text-start fw-bold text-3xl"></h1>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var options = {
                                            strings: ["SIKUDES."],
                                            typeSpeed: 200, // Kecepatan pengetikan (dalam milliseconds)
                                            backSpeed: 50, // Kecepatan penghapusan (dalam milliseconds)
                                            loop: true // Apakah animasi berulang
                                        };

                                        var typed = new Typed("#typed-output", options);
                                    });
                                </script>
                                <h6 class="pb-3">
                                    SIKUDES ini adalah sebuah solusi inovatif untuk mengelola dana desa di wilayah
                                    Panyiwi, Kabupaten Bone. Dikembangkan sebagai sistem informasi berbasis web,
                                    aplikasi ini tidak hanya menciptakan efisiensi dalam administrasi keuangan desa,
                                    tetapi juga menjanjikan pendekatan yang berbeda dalam pengembangan teknologi.</h6>
                                <a href="login.php" class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
                                        class="fe fe-lock me-2"></i> Login Admin
                                </a>
                                <a href="#About" class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"><i
                                        class="fe fe-eye me-2"></i>Tentang Aplikasi
                                </a>
                            </div>
                            <div class="col-xl-6 col-lg-6 my-auto">
                                <img src="sash/images/brand/banner.jpeg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--app-content open-->
            <div class="main-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container">
                        <div class="">

                            <div class="sptb section bg-white" id="Features">
                                <div class="container">
                                    <div class="row">
                                        <h4 class="text-center fw-semibold">Fitur</h4>
                                        <span class="landing-title"></span>
                                        <p class="text-default mb-5 text-center">SIKUDES ini adalah sebuah solusi
                                            inovatif untuk mengelola dana desa di wilayah Panyiwi, Kabupaten Bone</p>
                                        <div class="row mt-7">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card features main-features main-features-1 wow fadeInUp reveal revealleft"
                                                    data-wow-delay="0.1s">
                                                    <div class="bg-img mb-2 text-left">
                                                        <svg width="50" height="50"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                                            <circle cx="64" cy="64" r="64"
                                                                fill="#42A3DB" />
                                                            <path fill="#347CBE"
                                                                d="M85.5 26.6L66.1 61 33.3 98.6 62.6 128H64c33.7 0 61.3-26 63.8-59.1L85.5 26.6z" />
                                                            <path fill="#CD2F30"
                                                                d="M73.1 57.7h-16c3.6 18.7 11.1 36.6 22.1 52.5.3-5 1-9.8 1.8-14.5 4.6 1.3 9.2 2.3 13.7 3-9.7-12.2-17-26.1-21.6-41z" />
                                                            <path fill="#F04D45"
                                                                d="M54.9 57.7c-4.6 15-11.9 28.9-21.6 40.9 4.5-.7 9.1-1.7 13.7-3 .9 4.7 1.5 9.5 1.8 14.5 11-15.9 18.4-33.8 22.1-52.5h-16z" />
                                                            <path fill="#FFF"
                                                                d="M93.5 52c1.8-1.8 1.8-4.7 0-6.5-1.3-1.3-1.7-3.3-1-5 1-2.4-.1-5-2.5-6-1.7-.7-2.8-2.4-2.8-4.3 0-2.5-2.1-4.6-4.6-4.6-1.9 0-3.5-1.1-4.3-2.8-1-2.4-3.7-3.5-6-2.5-1.7.7-3.7.3-5-1-1.8-1.8-4.7-1.8-6.5 0-1.3 1.3-3.3 1.7-5 1-2.4-1-5 .1-6 2.5-.7 1.7-2.4 2.8-4.3 2.8-2.5 0-4.6 2.1-4.6 4.6 0 1.9-1.1 3.5-2.8 4.3-2.4 1-3.5 3.7-2.5 6 .7 1.7.3 3.7-1 5-1.8 1.8-1.8 4.7 0 6.5 1.3 1.3 1.7 3.3 1 5-1 2.4.1 5 2.5 6 1.7.7 2.8 2.4 2.8 4.3 0 2.5 2.1 4.6 4.6 4.6 1.9 0 3.5 1.1 4.3 2.8 1 2.4 3.7 3.5 6 2.5 1.7-.7 3.7-.3 5 1 1.8 1.8 4.7 1.8 6.5 0 1.3-1.3 3.3-1.7 5-1 2.4 1 5-.1 6-2.5.7-1.7 2.4-2.8 4.3-2.8 2.5 0 4.6-2.1 4.6-4.6 0-1.9 1.1-3.5 2.8-4.3 2.4-1 3.5-3.7 2.5-6-.7-1.7-.3-3.7 1-5z" />
                                                            <path fill="#FFCD0A"
                                                                d="M64 70.8c-12.2 0-22.1-9.9-22.1-22.1 0-12.2 9.9-22.1 22.1-22.1 12.2 0 22.1 9.9 22.1 22.1 0 12.2-9.9 22.1-22.1 22.1z" />
                                                            <path fill="#FFF"
                                                                d="M59.9 61c-.6 0-1.1-.2-1.5-.7l-8.3-9.2c-.7-.8-.7-2.1.1-2.8.8-.7 2.1-.7 2.8.1l6.7 7.5 15.1-18.8c.7-.9 2-1 2.8-.3.9.7 1 2 .3 2.8L61.4 60.2c-.3.5-.9.8-1.5.8z" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <h4 class="fw-bold">Penggajian</h4>
                                                        <p class="mb-0">Proses penggajian staf desa non-ASN, mencakup
                                                            administrasi gaji dan keuangan dalam lingkup kepegawaian
                                                            desa.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card  features main-features main-features-2 wow fadeInUp reveal revealleft"
                                                    data-wow-delay="0.1s">
                                                    <div class="bg-img mb-2 text-left">
                                                        <svg width="50" height="50"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                                            <circle cx="64" cy="64" r="64"
                                                                fill="#FFCD0A" />
                                                            <path fill="#F6AF1A"
                                                                d="M127.7 57.7l-26.4-26.4-74.7 58.8L64.5 128c35.1-.3 63.5-28.8 63.5-64 0-2.1-.1-4.2-.3-6.3z" />
                                                            <path fill="#CFD5DF" d="M76.2 102.9H51.8l2-13.6h20.4z" />
                                                            <path fill="#545E70"
                                                                d="M97.1 91.7H30.9c-3.5 0-6.4-2.9-6.4-6.4V36.1c0-3.5 2.9-6.4 6.4-6.4h66.2c3.5 0 6.4 2.9 6.4 6.4v49.3c0 3.5-2.9 6.3-6.4 6.3z" />
                                                            <path fill="#E6E8EB"
                                                                d="M24.5 81.4v4c0 3.5 2.9 6.4 6.4 6.4h66.2c3.5 0 6.4-2.9 6.4-6.4v-4h-79z" />
                                                            <path fill="#49C7EF"
                                                                d="M30.9 74.3c-1 0-1.8-.8-1.8-1.8V36.1c0-1 .8-1.8 1.8-1.8h66.2c1 0 1.8.8 1.8 1.8v36.4c0 1-.8 1.8-1.8 1.8H30.9z" />
                                                            <path fill="#17B6EA" d="M37.8 34.3h52.5v40H37.8z" />
                                                            <path fill="#E6E8EB"
                                                                d="M76.7 105.3H51.3c-1.3 0-2.4-1.1-2.4-2.4 0-1.3 1.1-2.4 2.4-2.4h25.4c1.3 0 2.4 1.1 2.4 2.4-.1 1.3-1.1 2.4-2.4 2.4z" />
                                                            <path fill="#ACB2B9" d="M53.2 91.7l22.7 8.8-1.3-8.8z" />
                                                            <path fill="#FFF"
                                                                d="M75.7 47.8H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1zM75.7 57.1H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1V56c0 .6-.4 1.1-1 1.1z" />
                                                            <path fill="#FFCD0A"
                                                                d="M62.8 65.9H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h10.4c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1z" />
                                                            <g fill="#CFD5DF">
                                                                <circle cx="54.1" cy="45.3" r="1.2" />
                                                                <circle cx="57.6" cy="45.3" r="1.2" />
                                                                <circle cx="61" cy="45.3" r="1.2" />
                                                                <circle cx="64.5" cy="45.3" r="1.2" />
                                                                <circle cx="67.9" cy="45.3" r="1.2" />
                                                            </g>
                                                            <g fill="#CFD5DF">
                                                                <circle cx="54.1" cy="54.6" r="1.2" />
                                                                <circle cx="57.6" cy="54.6" r="1.2" />
                                                                <circle cx="61" cy="54.6" r="1.2" />
                                                                <circle cx="64.5" cy="54.6" r="1.2" />
                                                                <circle cx="67.9" cy="54.6" r="1.2" />
                                                            </g>
                                                            <g fill="#FFF">
                                                                <path
                                                                    d="M56.9 64.4c-.3.3-.6.4-1 .4s-.8-.1-1-.4c-.3-.3-.4-.6-.4-1s.1-.7.4-1c.3-.3.6-.4 1-.4s.8.1 1 .4c.3.3.4.6.4 1s-.1.7-.4 1zm-.2-1c0-.2-.1-.5-.2-.6-.2-.2-.4-.3-.6-.3s-.4.1-.6.3c-.2.2-.2.4-.2.6 0 .2.1.5.2.6.2.2.4.3.6.3s.4-.1.6-.3c.1-.2.2-.4.2-.6zM58.3 62h.6v1.1l1-1.1h.8l-1.1 1.2c.1.1.3.4.5.7s.4.6.6.8H60l-.8-1.1-.3.4v.8h-.6V62z" />
                                                            </g>
                                                            <circle cx="64" cy="86.6" r="2.8"
                                                                fill="#545E70" />
                                                            <g fill="#E6E8EB">
                                                                <path
                                                                    d="M92.6 49.7v9.2c0 1.2 1.6 1.6 2.2.5l2.3-4.6c.2-.3.2-.7 0-1l-2.3-4.6c-.6-1.1-2.2-.7-2.2.5zM36.1 58.9v-9.2c0-1.2-1.6-1.6-2.2-.5l-2.3 4.6c-.2.3-.2.7 0 1l2.3 4.6c.6 1.1 2.2.7 2.2-.5z" />
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <h4 class="fw-bold">Pembiayaan</h4>
                                                        <p class="mb-0">Informasi tentang pembiayaan untuk pembaruan
                                                            sistem, investasi, dan proyek strategis dalam anggaran desa.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card features main-features main-features-11 wow fadeInUp reveal revealleft"
                                                    data-wow-delay="0.1s">
                                                    <div class="bg-img mb-2 text-left">
                                                        <svg id="SvgjsSvg1001" width="50" height="50"
                                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs">
                                                            <defs id="SvgjsDefs1002"></defs>
                                                            <g id="SvgjsG1008"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 128 128" width="50"
                                                                    height="50">
                                                                    <circle cx="64" cy="64" r="64"
                                                                        fill="#bed530" class="colorBED530 svgShape">
                                                                    </circle>
                                                                    <path fill="#acc437"
                                                                        d="M112.8 53.7l-4.6-3.7L85 27l-.9 6.9H77L70 27l-1.3 3.7-6 5.7-9.4-9.4-.9 3.7-8.9 2.3-6-6-5 8.2-3.9 63.7 28.9 28.8c2.2.2 4.4.3 6.6.3 33.7 0 61.4-26.2 63.8-59.3l-15.1-15z"
                                                                        class="colorACC437 svgShape"></path>
                                                                    <path fill="#ffffff"
                                                                        d="M86.5 101.8H34.2c-3.6 0-6.5-2.9-6.5-6.5v-58c0-3.6 2.9-6.5 6.5-6.5h52.3c3.6 0 6.5 2.9 6.5 6.5v58c0 3.6-2.9 6.5-6.5 6.5z"
                                                                        class="colorFFF svgShape"></path>
                                                                    <path fill="#e6e8eb"
                                                                        d="M75.6 78l-9.5 12.3 11.5 11.5h8.8c3.6 0 6.5-2.9 6.5-6.5V67.7L75.6 78z"
                                                                        class="colorE6E8EB svgShape"></path>
                                                                    <path fill="#e2247e" d="M88.5 58.8h8v31.9h-8z"
                                                                        transform="rotate(-135.032 92.483 74.797)"
                                                                        class="colorE2247E svgShape"></path>
                                                                    <path fill="#ee3e88" d="M82.9 53.2h8v31.9h-8z"
                                                                        transform="rotate(-135.032 86.846 69.166)"
                                                                        class="colorEE3E88 svgShape"></path>
                                                                    <path fill="#f06197" d="M77.2 47.6h8v31.9h-8z"
                                                                        transform="rotate(-135.032 81.209 63.535)"
                                                                        class="colorF06197 svgShape"></path>
                                                                    <path fill="#cfd5df" d="M87 56h23.9v2.2H87z"
                                                                        transform="rotate(-135.032 98.922 57.076)"
                                                                        class="colorCFD5DF svgShape"></path>
                                                                    <path fill="#545e70"
                                                                        d="M102.2 43.2l10.5 10.5c1.8 1.8 1.8 4.6 0 6.4l-4.6 4.6-16.8-16.9 4.6-4.6c1.7-1.7 4.6-1.7 6.3 0z"
                                                                        class="color545E70 svgShape"></path>
                                                                    <path fill="#fcd65e"
                                                                        d="M67.1 72l-1.7 16.7c-.1 1.1.8 2 1.9 1.9L84 88.9 67.1 72z"
                                                                        class="colorFCD65E svgShape"></path>
                                                                    <path fill="#f6af1a"
                                                                        d="M65.4 88.7c-.1.6.2 1.1.5 1.5l9.6-9.6-8.4-8.6-1.7 16.7z"
                                                                        class="colorF6AF1A svgShape"></path>
                                                                    <path fill="#ffcd0a"
                                                                        d="M66.1 90.3l12.2-7-5.6-5.6-7 12.2c.2.1.3.3.4.4z"
                                                                        class="colorFFCD0A svgShape"></path>
                                                                    <path fill="#7d6c7c"
                                                                        d="M65.9 83.9l-.5 4.8c-.1 1.1.8 2 1.9 1.9l4.8-.5-6.2-6.2z"
                                                                        class="color7D6C7C svgShape"></path>
                                                                    <path fill="#5b4b57"
                                                                        d="M65.9 83.9l-.5 4.8c-.1.6.2 1.1.5 1.5l3.1-3.1-3.1-3.2z"
                                                                        class="color5B4B57 svgShape"></path>
                                                                    <path fill="#6b5969"
                                                                        d="M68 86l-2.2 3.9c.1.2.2.3.4.4l3.9-2.3-2.1-2z"
                                                                        class="color6B5969 svgShape"></path>
                                                                    <circle cx="84.1" cy="39.6" r="4.1"
                                                                        fill="#bed530" class="colorBED530 svgShape">
                                                                    </circle>
                                                                    <circle cx="68.2" cy="39.6" r="4.1"
                                                                        fill="#bed530" class="colorBED530 svgShape">
                                                                    </circle>
                                                                    <circle cx="52.4" cy="39.6" r="4.1"
                                                                        fill="#bed530" class="colorBED530 svgShape">
                                                                    </circle>
                                                                    <circle cx="36.5" cy="39.6" r="4.1"
                                                                        fill="#bed530" class="colorBED530 svgShape">
                                                                    </circle>
                                                                    <path fill="#545e70"
                                                                        d="M84.1 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c.1 1.1-.8 1.9-1.9 1.9zM68.3 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1.1-.9 1.9-1.9 1.9zM52.4 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.9 1.9-1.9 1.9zM36.5 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.8 1.9-1.9 1.9z"
                                                                        class="color545E70 svgShape"></path>
                                                                </svg></g>
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <h4 class="fw-bold">Belanja</h4>
                                                        <p class="mb-0">Detail belanja untuk pengadaan kantor,
                                                            peralatan baru, dan biaya pemeliharaan serta maintenance.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
                                                    data-wow-delay="0.1s">
                                                    <div class="bg-img mb-2 text-left">
                                                        <svg width="50" height="50"
                                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs">
                                                            <defs id="SvgjsDefs1055"></defs>
                                                            <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 128 128" width="50"
                                                                    height="50">
                                                                    <circle cx="64" cy="64" r="64"
                                                                        fill="#58e1ef" class="colorD9B9A9 svgShape">
                                                                    </circle>
                                                                    <path fill="#47d4e4"
                                                                        d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
                                                                        class="colorD6AB9A svgShape"></path>
                                                                    <path fill="#6b5969"
                                                                        d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
                                                                        class="color6B5969 svgShape"></path>
                                                                    <circle cx="64" cy="28.8" r="14.8"
                                                                        fill="#ffffff" class="colorFFF svgShape">
                                                                    </circle>
                                                                    <path fill="#8663a7"
                                                                        d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
                                                                        class="color8663A7 svgShape"></path>
                                                                    <circle cx="64" cy="99.2" r="14.8"
                                                                        fill="#ffffff" class="colorFFF svgShape">
                                                                    </circle>
                                                                    <path fill="#3d9c46"
                                                                        d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
                                                                        class="color3D9C46 svgShape"></path>
                                                                    <circle cx="99.2" cy="64" r="14.8"
                                                                        fill="#ffffff" class="colorFFF svgShape">
                                                                    </circle>
                                                                    <path fill="#ee3e88"
                                                                        d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
                                                                        class="colorEE3E88 svgShape"></path>
                                                                    <circle cx="28.8" cy="64" r="14.8"
                                                                        fill="#ffffff" class="colorFFF svgShape">
                                                                    </circle>
                                                                    <path fill="#ffcd0a"
                                                                        d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
                                                                        class="colorFFCD0A svgShape"></path>
                                                                    <path fill="#ffffff"
                                                                        d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
                                                                        class="colorFFF svgShape"></path>
                                                                </svg></g>
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <h4 class="fw-bold">Pendapatan</h4>
                                                        <p class="mb-0">Rincian pendapatan untuk berbagai bulan dan
                                                            tahun, termasuk pendapatan awal tahun, bonus karyawan, dan
                                                            pendapatan akhir tahun.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <!-- CONTAINER CLOSED-->
                </div>
            </div>
            <!--app-content closed-->
        </div>

        <div class="demo-footer" id="About">
            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="top-footer">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-md-12 reveal revealleft">
                                        <h6>Tentang Sikudes</h6>
                                        <p>SIKUDES ini adalah sebuah solusi inovatif untuk mengelola dana desa di
                                            wilayah Panyiwi, Kabupaten Bone. Dikembangkan sebagai sistem informasi
                                            berbasis web, aplikasi ini tidak hanya menciptakan efisiensi dalam
                                            administrasi keuangan desa, tetapi juga menjanjikan pendekatan yang berbeda
                                            dalam pengembangan teknologi.
                                        </p>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-4 reveal revealleft">
                                        <h6>Halaman</h6>
                                        <ul class="list-unstyled mb-5 mb-lg-0">
                                            <li><a href="">Dashboard Statistik</a></li>
                                            <li><a href="">Pengelolaan Pendapatan</a></li>
                                            <li><a href="">Pengelolaan Pembiayaan</a></li>
                                            <li><a href="">Pengelolaan Penggajian</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-md-4 reveal revealleft">
                                        <h6>Information</h6>
                                        <ul class="list-unstyled mb-5 mb-lg-0">
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Contact US</a></li>
                                            <li><a href="">About</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-md-4 reveal revealleft">
                                        <div class="">
                                            <a href=""><img loading="lazy" alt="" class="logo-2 mb-3"
                                                    src="sash/images/brand/logo-3.png"></a>
                                            <a href=""><img src="sash/images/brand/logo.png" class="logo-3"
                                                    alt="logo"></a>
                                            <p>SIKUDES ini adalah sebuah solusi inovatif untuk mengelola dana desa di
                                                wilayah Panyiwi, Kabupaten Bone.</p>
                                        </div>
                                        <div class="btn-list mt-6">
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fa fa-facebook"></i></button>
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fa fa-youtube"></i></button>
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fa fa-twitter"></i></button>
                                            <button type="button" class="btn btn-icon rounded-pill"><i
                                                    class="fa fa-instagram"></i></button>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <footer class="main-footer px-0 pb-0 text-center">
                                <div class="row ">
                                    <div class="col-md-12 col-sm-12">
                                        Copyright © <span id="year"></span> <a
                                            href="javascript:void(0)">SIKUDES</a>.
                                        Designed with by <a href="javascript:void(0)"> A.BASO SULTAN </a> All rights
                                        reserved.
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <script src="sash/js/jquery.min.js"></script>
    <script src="sash/plugins/bootstrap/js/popper.min.js"></script>
    <script src="sash/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="sash/plugins/counters/counterup.min.js"></script>
    <script src="sash/plugins/counters/waypoints.min.js"></script>
    <script src="sash/plugins/counters/counters-1.js"></script>
    <script src="sash/plugins/company-slider/slider.js"></script>
    <script src="sash/plugins/rating/jquery-rate-picker.js"></script>
    <script src="sash/plugins/rating/rating-picker.js"></script>
    <script src="sash/plugins/ratings-2/star-rating.js"></script>
    <script src="sash/js/sticky.js"></script>
    <script src="sash/js/landing.js"></script>
</body>
</html>