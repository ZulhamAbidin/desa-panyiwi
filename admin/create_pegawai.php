<?php include 'src/header.php'; ?>
<?php
include '../koneksi.php';

$nama = '';
$jabatan = '';
$nomor_identifikasi = '';
$email = '';
$nomor_telepon = '';
$alamat = '';
$periode_pembayaran = '';
$file_path = '';
$pendidikan_terakhir = ''; // Ditambahkan
$status_pernikahan = ''; // Ditambahkan
$agama = ''; // Ditambahkan
$tempat_lahir = ''; // Ditambahkan
$tanggal_lahir = ''; // Ditambahkan
$jenis_kelamin = ''; // Ditambahkan
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $nomor_identifikasi = $_POST['nomor_identifikasi'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $periode_pembayaran = $_POST['periode_pembayaran'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir']; // Ditambahkan
    $status_pernikahan = $_POST['status_pernikahan']; // Ditambahkan
    $agama = $_POST['agama']; // Ditambahkan
    $tempat_lahir = $_POST['tempat_lahir']; // Ditambahkan
    $tanggal_lahir = $_POST['tanggal_lahir']; // Ditambahkan
    $jenis_kelamin = $_POST['jenis_kelamin']; // Ditambahkan

    $uploadDir = __DIR__ . '/gambar/';
    $file_path = '';

    if ($_FILES['foto_pegawai']['size'] > 0) {
        $fileName = basename($_FILES['foto_pegawai']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $randomFileName = uniqid() . '.' . $fileExtension;
        $file_path = $randomFileName;
        $targetPath = $uploadDir . $randomFileName;
        if (move_uploaded_file($_FILES['foto_pegawai']['tmp_name'], $targetPath)) {
        } else {
            $_SESSION['error_message'] = "Gagal mengunggah foto pegawai.";
            header("Location: create_gaji.php");
            exit();
        }
    }

    $check_sql = "SELECT * FROM pegawai WHERE email='$email' OR nomor_identifikasi='$nomor_identifikasi'";
    $result = $koneksi->query($check_sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['email'] == $email) {
                $error_message = "Email sudah ada!";
            } elseif ($row['nomor_identifikasi'] == $nomor_identifikasi) {
                $error_message = "Nomor identifikasi sudah ada!";
            }
        }
    } else {

        $sql = "INSERT INTO pegawai (nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran, foto_pegawai, pendidikan_terakhir, status_pernikahan, agama, tempat_lahir, tanggal_lahir, jenis_kelamin) 
                VALUES ('$nama', '$jabatan', '$nomor_identifikasi', '$email', '$nomor_telepon', '$alamat', '$periode_pembayaran', '$file_path', '$pendidikan_terakhir', '$status_pernikahan', '$agama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin')";
        
        if ($koneksi->query($sql) === true) {
            $_SESSION['success_message'] = "Pegawai baru berhasil disimpan!";
            header("Location: list_pegawai.php");
            exit();
        } else {
            $error_message = "Gagal menyimpan data pegawai: " . $koneksi->error;
        }
    }
}
?>
<div class="page-header">
    <h1 class="page-title">Tambah Data Pegawai</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-12">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="jabatan">Jabatan:</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo htmlspecialchars($jabatan); ?>" required>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="nomor_identifikasi">Nomor Identifikasi:</label>
                    <input type="text" class="form-control" id="nomor_identifikasi" name="nomor_identifikasi" value="<?php echo htmlspecialchars($nomor_identifikasi); ?>" required>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="nomor_telepon">Nomor Telepon:</label>
                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($nomor_telepon); ?>">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="foto_pegawai">Pas Foto:</label>
                    <input type="file" class="form-control" id="foto_pegawai" name="foto_pegawai">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="periode_pembayaran">Periode Pembayaran:</label>
                    <select class="form-control" id="periode_pembayaran" name="periode_pembayaran" required>
                        <option value="">Pilih Periode Pembayaran</option>
                        <option value="bulanan" <?php echo ($periode_pembayaran == 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                        <option value="triwulanan" <?php echo ($periode_pembayaran == 'triwulanan') ? 'selected' : ''; ?>>Triwulanan</option>
                        <option value="tahunan" <?php echo ($periode_pembayaran == 'tahunan') ? 'selected' : ''; ?>>Tahunan</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="pendidikan_terakhir">Pendidikan Terakhir:</label>
                    <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir">
                        <option value="">Pilih Pendidikan Terakhir</option>
                        <option value="TK" <?php echo ($pendidikan_terakhir == 'TK') ? 'selected' : ''; ?>>TK</option>
                        <option value="SD" <?php echo ($pendidikan_terakhir == 'SD') ? 'selected' : ''; ?>>SD</option>
                        <option value="SMP" <?php echo ($pendidikan_terakhir == 'SMP') ? 'selected' : ''; ?>>SMP</option>
                        <option value="SMA" <?php echo ($pendidikan_terakhir == 'SMA') ? 'selected' : ''; ?>>SMA</option>
                        <option value="Diploma 3" <?php echo ($pendidikan_terakhir == 'Diploma 3') ? 'selected' : ''; ?>>Diploma 3</option>
                        <option value="Diploma 4" <?php echo ($pendidikan_terakhir == 'Diploma 4') ? 'selected' : ''; ?>>Diploma 4</option>
                        <option value="Strata 1" <?php echo ($pendidikan_terakhir == 'Strata 1') ? 'selected' : ''; ?>>Strata 1</option>
                        <option value="Strata 2" <?php echo ($pendidikan_terakhir == 'Strata 2') ? 'selected' : ''; ?>>Strata 2</option>
                        <option value="Strata 3" <?php echo ($pendidikan_terakhir == 'Strata 3') ? 'selected' : ''; ?>>Strata 3</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="status_pernikahan">Status Pernikahan:</label>
                    <select class="form-control" id="status_pernikahan" name="status_pernikahan">
                        <option value="">Pilih Status Pernikahan</option>
                        <option value="Belum Menikah" <?php echo ($status_pernikahan == 'Belum Menikah') ? 'selected' : ''; ?>>Belum Menikah</option>
                        <option value="Menikah" <?php echo ($status_pernikahan == 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
                        <option value="Cerai" <?php echo ($status_pernikahan == 'Cerai') ? 'selected' : ''; ?>>Cerai</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="agama">Agama:</label>
                    <select class="form-control" id="agama" name="agama">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" <?php echo ($agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                        <option value="Kristen" <?php echo ($agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                        <option value="Katolik" <?php echo ($agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                        <option value="Hindu" <?php echo ($agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                        <option value="Buddha" <?php echo ($agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                        <option value="Khonghucu" <?php echo ($agama == 'Khonghucu') ? 'selected' : ''; ?>>Khonghucu</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="tempat_lahir">Tempat Lahir:</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo htmlspecialchars($tempat_lahir); ?>">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" <?php echo ($jenis_kelamin == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo ($jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-12 col-md-12 mt-2">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat"><?php echo htmlspecialchars($alamat); ?></textarea>
                </div>
                <div class="col-12 col-md-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastSuccess" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto">Berhasil!</strong>
            <button type="button" class="btn-close text-white btn-primary" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Tempat untuk menampilkan pesan sukses -->
        </div>
    </div>
    <div id="toastError" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto">Kesalahan!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Tempat untuk menampilkan pesan kesalahan -->
        </div>
    </div>
</div>

<?php include 'src/footer.php'; ?>

<?php
if (!empty($error_message)) {
    echo '
    <script>
    $(document).ready(function() {
        var toastError = new bootstrap.Toast(document.getElementById("toastError"));
        $(".toast-body", toastError.element).text("' . $error_message . '");
        toastError.show();
    });
    </script>
    ';
}
?>