<?php
include 'src/header.php';
include '../koneksi.php';

$id_pegawai = $_GET['id'];

// Fetch existing data
$sql = "SELECT nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran FROM pegawai WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($nama, $jabatan, $nomor_identifikasi, $email, $nomor_telepon, $alamat, $periode_pembayaran);
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
        $sql_update = "UPDATE pegawai SET nama = ?, jabatan = ?, nomor_identifikasi = ?, email = ?, nomor_telepon = ?, alamat = ?, periode_pembayaran = ? WHERE id = ?";
        $stmt_update = $koneksi->prepare($sql_update);
        $stmt_update->bind_param("sssssssi", $nama, $jabatan, $nomor_identifikasi, $email, $nomor_telepon, $alamat, $periode_pembayaran, $id_pegawai);

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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_pegawai; ?>" method="post">
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
                        <!-- <option value="tahunan" <?php if ($periode_pembayaran == 'tahunan') echo 'selected'; ?>>Tahunan</option> -->
                    </select>
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
