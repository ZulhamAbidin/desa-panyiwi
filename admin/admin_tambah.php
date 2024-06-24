<?php
include 'src/header.php';

$alertMessage = '';
$namaValue = ''; 
$usernameValue = '';
$insert_stmt = null;

if (isset($_POST['simpan'])) {
    $namaValue = $_POST['nama'];
    $usernameValue = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $alertMessage = 'Password harus memiliki minimal 6 karakter';
    } else {

        $check_username_stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username=?");
        mysqli_stmt_bind_param($check_username_stmt, "s", $usernameValue);
        mysqli_stmt_execute($check_username_stmt);
        mysqli_stmt_store_result($check_username_stmt);

        if (mysqli_stmt_num_rows($check_username_stmt) > 0) {
            $alertMessage = 'Gagal menyimpan data. Username sudah digunakan.';
        } else {
            $insert_stmt = mysqli_prepare($koneksi, "INSERT INTO user (nama, username, password) VALUES (?, ?, ?)");
            
            if ($insert_stmt) {
                $hashed_password = md5($password);
                mysqli_stmt_bind_param($insert_stmt, "sss", $namaValue, $usernameValue, $hashed_password);
                $simpan = mysqli_stmt_execute($insert_stmt);

                if ($simpan) {
                    $alertMessage = 'Data Berhasil Disimpan';

                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "' . $alertMessage . '",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "data_admin.php";
                            });
                          </script>';
                    exit;
                } else {
                    $alertMessage = 'Gagal menyimpan data';
                }
            } else {
                $alertMessage = 'Gagal membuat prepared statement untuk penyimpanan data';
            }
        }

        mysqli_stmt_close($check_username_stmt);
        
        if ($insert_stmt) {
            mysqli_stmt_close($insert_stmt);
        }
    }
}
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Tambah Data Admin</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Admin</h3>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <?php
                if (!empty($alertMessage)) {
                    echo '<div class="alert alert-danger" role="alert">' . $alertMessage . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="nama">Nama Admin</label>
                    <input type="text" class="form-control" name="nama" value="<?= $namaValue ?>" autocomplete="off"
                        placeholder="Input Nama Admin" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $usernameValue ?>"
                        autocomplete="off" placeholder="Input Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off"
                        placeholder="Input Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class='btn btn-md btn-primary' name="simpan"><span aria-hidden="true"></span>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'src/footer.php'; ?>