<?php
include 'src/header.php';

$alertMessage = '';
$namaValue = ''; 
$usernameValue = '';

if(isset($_POST['simpan'])){
    $id = isset($_GET['id_admin']) ? $_GET['id_admin'] : null;
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (strlen($password) < 6) {
        $alertMessage = 'Password harus memiliki minimal 6 karakter';
    } else {

        $check_username_stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username=? AND id_admin != ?");
        mysqli_stmt_bind_param($check_username_stmt, "si", $username, $id);
        mysqli_stmt_execute($check_username_stmt);
        mysqli_stmt_store_result($check_username_stmt);

        if (mysqli_stmt_num_rows($check_username_stmt) > 0) {
            $alertMessage = 'Username sudah digunakan';
        } else {

            $update_stmt = mysqli_prepare($koneksi, "UPDATE user SET nama=?, username=?, password=? WHERE id_admin=?");

            if ($update_stmt) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($update_stmt, "sssi", $nama, $username, $hashed_password, $id);
                $update = mysqli_stmt_execute($update_stmt);

                if ($update) {
                    $alertMessage = 'Data Berhasil Diupdate';
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
                    $alertMessage = 'Gagal mengupdate data';
                }

                mysqli_stmt_close($update_stmt);
            } else {
                $alertMessage = 'Gagal membuat prepared statement untuk mengupdate data';
            }
        }

        mysqli_stmt_close($check_username_stmt);
    }

    $namaValue = $nama;
    $usernameValue = $username;
}
?>

<div class="container">
  <div class="page-header">
        <h1 class="page-title">Edit Data Admin</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
  
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Data Admin</h3>
        </div>
        <?php
        $id = $_GET['id_admin'];

        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_admin = '$id'");
        $data  = mysqli_fetch_array($query);
        ?>
        <div class="card-body">
            <form action="" method="POST">
                <?php
                if (!empty($alertMessage)) {
                    echo '<div class="alert alert-danger" role="alert">' . $alertMessage . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="nama">Nama Admin</label>
                    <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>"  autocomplete="off" placeholder="Input Nama Admin" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" autocomplete="off" placeholder="Input Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Input Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class='btn btn-md btn-primary' name="simpan"><span aria-hidden="true"></span>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'src/footer.php'; ?>