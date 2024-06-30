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
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $nomor_identifikasi = $_POST['nomor_identifikasi'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $periode_pembayaran = $_POST['periode_pembayaran'];

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
        $sql = "INSERT INTO pegawai (nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran) 
                VALUES ('$nama', '$jabatan', '$nomor_identifikasi', '$email', '$nomor_telepon', '$alamat', '$periode_pembayaran')";

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
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo htmlspecialchars($jabatan); ?>" required>
            </div>
            <div class="form-group">
                <label for="nomor_identifikasi">Nomor Identifikasi:</label>
                <input type="text" class="form-control" id="nomor_identifikasi" name="nomor_identifikasi" value="<?php echo htmlspecialchars($nomor_identifikasi); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon:</label>
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($nomor_telepon); ?>">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" id="alamat" name="alamat"><?php echo htmlspecialchars($alamat); ?></textarea>
            </div>
            <div class="form-group">
                <label for="periode_pembayaran">Periode Pembayaran:</label>
                <select class="form-control" id="periode_pembayaran" name="periode_pembayaran">
                    <option value="bulanan" <?php if ($periode_pembayaran == 'bulanan') echo 'selected'; ?>>Bulanan</option>
                    <option value="triwulanan" <?php if ($periode_pembayaran == 'triwulanan') echo 'selected'; ?>>Triwulanan</option>
                    <!-- <option value="tahunan" <?php if ($periode_pembayaran == 'tahunan') echo 'selected'; ?>>Tahunan</option> -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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