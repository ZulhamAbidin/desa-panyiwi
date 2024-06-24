<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == "Login"){
    header("Location: admin/index.php");
    exit();
}

$statusLogin = '';
if(isset($_POST['login'])){
    include 'koneksi.php';
    $user = $_POST['username'];
    $pass = md5($_POST['password']); 
    $login = mysqli_query($koneksi,"SELECT * FROM user where username = '$user' and password = '$pass'");
    $cek = mysqli_num_rows($login);
    if($cek > 0){
        $data = mysqli_fetch_assoc($login);
        $_SESSION['login']   = "Login";
        $_SESSION['id']      = $data['id_admin'];
        $_SESSION['nama']    = $data['nama'];
        $statusLogin = 'success';
        sleep(1);
        header("Location: admin/index.php");
        exit();
    } else {
        $statusLogin = 'failed';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <title>Keuangan Login</title>
  <link rel="icon" type="image/png" href="sash/images/brand/logo-2.png" />
  <link rel="stylesheet" href="sash/login/css/app.css" />
  <script src="sash/login/js/app.js" defer></script>
  <script>
    localStorage.getItem("_x_darkMode_on") === "true" &&
      document.documentElement.classList.add("dark");
  </script>
</head>

<body x-data class="is-header-blur" x-bind="$store.global.documentBody">

<div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak>
  <main class="grid w-full grow grid-cols-1 place-items-center">

  <?php
if ($statusLogin == 'failed') {
    echo " <div
    class=' alert flex overflow-hidden rounded-lg border border-error text-error'
  >
    <div class='bg-error p-3 text-white'>
      <svg
        xmlns='http://www.w3.org/2000/svg'
        class='h-5 w-5'
        fill='none'
        viewBox='0 0 24 24'
        stroke='currentColor'
      >
        <path
          stroke-linecap='round'
          stroke-linejoin='round'
          stroke-width='2'
          d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        />
      </svg>
    </div>
    <div class='px-4 py-3 sm:px-5'>Login Gagal! Username dan Password Tidak Ditemukan</div>
  </div>";
} elseif ($statusLogin == 'success') {
    echo "<div class=' alert flex overflow-hidden rounded-lg border border-info text-info'>
            <div class='bg-info p-3 text-white'>
              <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' />
              </svg>
            </div>
            <div class='px-4 py-3 sm:px-5'>Login Berhasil! Selamat Datang, " . $_SESSION['nama'] . "</div>
          </div>";
          
}
?>
    <div class="w-full max-w-[26rem] p-4 sm:px-5">
      
      <div class="text-center">
        <img class="mx-auto h-24 w-24" src="sash/images/brand/logo-2.png" alt="logo" />
        <div class="mt-4">
          <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
            SISTEM INFORMASI
          </h2>
          <p class="text-slate-400 dark:text-navy-300">
            PENGELOLAAN DANA DESA PANYIWI KABUPATEN BONE
          </p>
        </div>
      </div>
      
      <form action="" method="post">
        <div class="card mt-5 rounded-lg p-5 lg:p-7">
          <label class="block">
            <span>Username:</span>
            <span class="relative mt-1.5 flex">
              <input
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Masukkan Username" name="username" type="text" />
              <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </span>
            </span>
          </label>
          <label class="mt-4 block">
            <span>Password:</span>
            <span class="relative mt-1.5 flex">
              <input
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Masukkan Password" name="password" type="password" />
              <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </span>
            </span>
          </label>
          <button type="submit" name="login" id="login"
            class="btn mt-5 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Sign In
          </button>
          <a href="index.php" "
            class="btn mt-5 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Home
          </a>
        </div>
      </form>
    </div>
  </main>
</div>
  <div id="x-teleport-target"></div>
  <script>
    window.addEventListener("DOMContentLoaded", () => Alpine.start());
  </script>
</body>
</html>