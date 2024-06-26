<?php
include 'src/header.php';
include '../koneksi.php';

$id_kategori = $_GET['id'];

$sql = "SELECT nama_kategori FROM kategori WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_kategori);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($nama_kategori);
    $stmt->fetch();
} else {
    $_SESSION['error_message'] = "Kategori tidak ditemukan.";
    header("Location: kategori_list.php");
    exit();
}

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kategori_baru = $_POST['nama_kategori'];

    $sql_update = "UPDATE kategori SET nama_kategori = ? WHERE id = ?";
    $stmt_update = $koneksi->prepare($sql_update);
    $stmt_update->bind_param("si", $nama_kategori_baru, $id_kategori);

    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Kategori berhasil diperbarui";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui kategori: " . $koneksi->error;
    }

    $stmt_update->close();

    header("Location: kategori_list.php");
    exit();
}
?>

<div class="page-header">
    <h1 class="page-title">Edit Data Kategori</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_kategori; ?>" method="post">
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
                    <label for="nama_kategori">Kategori:</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh Kategori Pendapatan" value="<?php echo htmlspecialchars($nama_kategori); ?>" required>
                </div>

                <div class="col-12 col-md-12 text-end mb-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'src/footer.php'; ?>