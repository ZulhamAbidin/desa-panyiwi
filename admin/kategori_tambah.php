<?php include 'src/header.php'; ?>

<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";

    if ($koneksi->query($sql) === true) {
        $_SESSION['success_message'] = "Kategori baru berhasil disimpan";
    } else {
        $_SESSION['error_message'] = "Gagal menyimpan kategori baru: " . $koneksi->error;
    }
    header("Location: kategori_list.php");
    exit();
}
?>

<div class="page-header">
    <h1 class="page-title">Tambah Data Kategori</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
                    <label for="nama_kategori">Kategori:</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh Kategori Pendapatan" required>
                </div>

                <div class="col-12 col-md-12 text-end mb-4">
                    <button type="submit" class="btn btn-primary">Simpan Kategori Baru</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'src/footer.php'; ?>
