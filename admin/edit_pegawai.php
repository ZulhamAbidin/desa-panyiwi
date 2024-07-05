<?php
include 'src/header.php';
include '../koneksi.php';

$id_pegawai = $_GET['id'];

$sql = "SELECT nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran, foto_pegawai, pendidikan_terakhir, status_pernikahan, agama, tempat_lahir, tanggal_lahir, jenis_kelamin FROM pegawai WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($nama, $jabatan, $nomor_identifikasi, $email, $nomor_telepon, $alamat, $periode_pembayaran, $foto_pegawai, $pendidikan_terakhir, $status_pernikahan, $agama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin);
    $stmt->fetch();
} else {
    $_SESSION['error_message'] = "Pegawai tidak ditemukan.";
    header("Location: list_pegawai.php");
    exit();
}

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $nomor_identifikasi = $_POST['nomor_identifikasi'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $periode_pembayaran = $_POST['periode_pembayaran'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
    $status_pernikahan = $_POST['status_pernikahan'];
    $agama = $_POST['agama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $uploadDir = __DIR__ . '/gambar/';
    $file_path = $foto_pegawai;

    if ($_FILES['foto_pegawai']['size'] > 0) {
        $fileName = basename($_FILES['foto_pegawai']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $randomFileName = uniqid() . '.' . $fileExtension;
        $file_path = $randomFileName;
        $targetPath = $uploadDir . $randomFileName;
        
        if (move_uploaded_file($_FILES['foto_pegawai']['tmp_name'], $targetPath)) {
            if (!empty($foto_pegawai)) {
                unlink($uploadDir . $foto_pegawai);
            }
        } else {
            $_SESSION['error_message'] = "Gagal mengunggah foto pegawai.";
            header("Location: edit_pegawai.php?id=" . $id_pegawai);
            exit();
        }
    }

    $check_sql = "SELECT email, nomor_identifikasi FROM pegawai WHERE (email = ? OR nomor_identifikasi = ?) AND id != ?";
    $stmt_check = $koneksi->prepare($check_sql);
    $stmt_check->bind_param("ssi", $email, $nomor_identifikasi, $id_pegawai);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_check->bind_result($row_email, $row_nomor_identifikasi);
        while ($stmt_check->fetch()) {
            if ($row_email == $email) {
                $error_message = "Email sudah ada!";
            } elseif ($row_nomor_identifikasi == $nomor_identifikasi) {
                $error_message = "Nomor identifikasi sudah ada!";
            }
        }
    } else {
        $sql_update = "UPDATE pegawai SET nama = ?, jabatan = ?, nomor_identifikasi = ?, email = ?, nomor_telepon = ?, alamat = ?, periode_pembayaran = ?, foto_pegawai = ?, pendidikan_terakhir = ?, status_pernikahan = ?, agama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ? WHERE id = ?";
        
        $stmt_update = $koneksi->prepare($sql_update);
        $stmt_update->bind_param("ssssssssssssssi", $nama, $jabatan, $nomor_identifikasi, $email, $nomor_telepon, $alamat, $periode_pembayaran, $file_path, $pendidikan_terakhir, $status_pernikahan, $agama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $id_pegawai);

        if ($stmt_update->execute()) {
            $_SESSION['success_message'] = "Pegawai berhasil diperbarui";
            header("Location: list_pegawai.php");
            exit();
        } else {
            $error_message = "Gagal memperbarui pegawai: " . $koneksi->error;
        }

        $stmt_update->close();
    }

    $stmt_check->close();
}

?>

<div class="page-header">
    <h1 class="page-title">Edit Data Pegawai</h1>
</div>

<div class="card">
    <div class="card-body">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_pegawai; ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 col-md-6 mb-4">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: John Doe" value="<?php echo htmlspecialchars($nama); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="jabatan">Jabatan:</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Contoh: Manager" value="<?php echo htmlspecialchars($jabatan); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="nomor_identifikasi">Nomor Identifikasi:</label>
            <input type="text" class="form-control" id="nomor_identifikasi" name="nomor_identifikasi" placeholder="Contoh: 123456" value="<?php echo htmlspecialchars($nomor_identifikasi); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: johndoe@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="nomor_telepon">Nomor Telepon:</label>
            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" placeholder="Contoh: 081234567890" value="<?php echo htmlspecialchars($nomor_telepon); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="alamat">Alamat:</label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Contoh: Jl. Merdeka No. 10" value="<?php echo htmlspecialchars($alamat); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="periode_pembayaran">Periode Pembayaran:</label>
            <select class="form-control" id="periode_pembayaran" name="periode_pembayaran" required>
                <option value="bulanan" <?php if ($periode_pembayaran == 'bulanan') echo 'selected'; ?>>Bulanan</option>
                <option value="triwulanan" <?php if ($periode_pembayaran == 'triwulanan') echo 'selected'; ?>>Triwulanan</option>
                <option value="tahunan" <?php if ($periode_pembayaran == 'tahunan') echo 'selected'; ?>>Tahunan</option>
            </select>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="pendidikan_terakhir">Pendidikan Terakhir:</label>
            <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir">
                <option value="">Pilih Pendidikan</option>
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
        <div class="col-12 col-md-6 mb-4">
            <label for="status_pernikahan">Status Pernikahan:</label>
            <select class="form-control" id="status_pernikahan" name="status_pernikahan">
                <option value="">Pilih Status</option>
                <option value="Belum Menikah" <?php echo ($status_pernikahan == 'Belum Menikah') ? 'selected' : ''; ?>>Belum Menikah</option>
                <option value="Menikah" <?php echo ($status_pernikahan == 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
                <option value="Cerai" <?php echo ($status_pernikahan == 'Cerai') ? 'selected' : ''; ?>>Cerai</option>
            </select>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="agama">Agama:</label>
            <select class="form-control" id="agama" name="agama">
                <option value="">Pilih Agama</option>
                <option value="Islam" <?php echo ($agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                <option value="Kristen" <?php echo ($agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                <option value="Katolik" <?php echo ($agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                <option value="Hindu" <?php echo ($agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                <option value="Buddha" <?php echo ($agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                <option value="Konghucu" <?php echo ($agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
            </select>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="tempat_lahir">Tempat Lahir:</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Contoh: Jakarta" value="<?php echo htmlspecialchars($tempat_lahir); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>" required>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" <?php if ($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                <option value="Perempuan" <?php if ($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
            </select>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <label for="foto_pegawai">Foto Pegawai:</label>
            <input type="file" class="form-control" id="foto_pegawai" name="foto_pegawai">
            <?php if (!empty($foto_pegawai)) : ?>
                <img src="gambar/<?php echo htmlspecialchars($foto_pegawai); ?>" class="img-fluid mt-2" alt="Foto Pegawai">
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-12 text-end mb-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
if (!empty($_SESSION['success_message'])) {
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
?>

<?php include 'src/footer.php'; ?>