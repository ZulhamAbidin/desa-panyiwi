<?php
include 'src/header.php';
include '../koneksi.php';

// Ambil pegawai_id dari parameter URL 'id'
$id_pegawai = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT nama, jabatan, nomor_identifikasi, email, nomor_telepon, alamat, periode_pembayaran, foto_pegawai FROM pegawai WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($nama, $jabatan, $nomor_identifikasi, $email, $nomor_telepon, $alamat, $periode_pembayaran, $foto_pegawai);
    $stmt->fetch();
} else {
    $_SESSION['error_message'] = "Pegawai tidak ditemukan.";
    header("Location: list_pegawai.php");
    exit();
}

$stmt->close();

$pegawai_id = $id_pegawai;
?>

<div class="page-header">
    <h1 class="page-title">Detail Pegawai</h1>
</div>


    <div class="row">

        <div class="col-12 col-md-4">
            <div class="card">

                <div class="card-body text-center">
                    <?php if (!empty($foto_pegawai)) : ?>

                    <div class="avatar avatar-xxl brround cover-image mb-4"
                        style="background: url('gambar/<?php echo htmlspecialchars($foto_pegawai); ?>') center top / cover; width: 150px; height: 150px;">
                    </div>

                    <?php else : ?>

                    <div class="avatar avatar-xxl brround cover-image"
                        style="background: url('gambar/default.jpg') center top / cover; width: 250px; height: 250px;">
                    </div>

                    <?php endif; ?>

                    <div class="text-left mt-4">
                        <h4 class="h4 mb-0 mt-3"><?php echo htmlspecialchars($nama); ?></h4>
                        <p class="card-text"><?php echo htmlspecialchars($jabatan); ?></p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kontak</div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 mt-3">
                        <div class="me-4 text-center text-primary">
                            <span><i class="fe fe-briefcase fs-20"></i></span>
                        </div>
                        <div>
                            <strong><?php echo htmlspecialchars($nomor_identifikasi); ?></strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mt-3">
                        <div class="me-4 text-center text-primary">
                            <span><i class="fe fe-map-pin fs-20"></i></span>
                        </div>
                        <div>
                            <strong><?php echo htmlspecialchars($alamat); ?></strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mt-3">
                        <div class="me-4 text-center text-primary">
                            <span><i class="fe fe-phone fs-20"></i></span>
                        </div>
                        <div>
                            <strong><?php echo htmlspecialchars($nomor_telepon); ?> </strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mt-3">
                        <div class="me-4 text-center text-primary">
                            <span><i class="fe fe-mail fs-20"></i></span>
                        </div>
                        <div>
                            <strong><?php echo htmlspecialchars($email); ?> </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="notification" id="notificationList">
            </div>
        </div>

        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar Slip Gaji</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" src="" alt="Slip Gaji" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

    </div>


<script>
    $(document).ready(function () {
        var pegawai_id = '<?php echo $pegawai_id; ?>';
        $.ajax({
            url: 'controller/fetch_histori_gaji_detail.php',
            type: 'GET',
            data: {
                pegawai_id: pegawai_id
            },
            success: function (response) {
                var data = JSON.parse(response);
                $('#namaPegawai').text(data.namaPegawai);

                var notificationList = $('#notificationList');
                data.data.forEach(function (item, index) {
                    var date = new Date(item.tanggal_pembayaran);
                    var day = date.toLocaleString('id-ID', {
                        weekday: 'long'
                    });
                    var dayNumber = date.toLocaleString('id-ID', {
                        day: 'numeric'
                    });
                    var monthYear = date.toLocaleString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });

                    var fileButton = item.file_path ?
                        `<button type="button" class="btn btn-sm btn-primary view-image-btn" data-file-path="gambar/${item.file_path}"><i class="fa fa-eye"></i></button>` :
                        '';

                    var notificationItem = `
                        <li>
                            <div class="notification-time">
                                <span class="date fw-semibold fs-15 text-dark">${day}</span>
                                <span class="time fw-semibold fs-15 text-dark">${dayNumber}, ${monthYear}</span>
                            </div>
                            <div class="notification-icon">
                                <a href="javascript:void(0);"></a>
                            </div>
                            <div class="notification-body">
                                <div class="media mt-0">
                                    <div class="main-avatar avatar-md online">
                                        ${fileButton}
                                    </div>
                                    <div class="media-body ms-3 d-flex">
                                        <div class="">
                                            <p class="fs-15 text-dark fw-bold mb-0 pt-3">${item.periode_pembayaran}</p>
                                            <div class="row">
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">Gaji Pokok</p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">: ${item.gaji_pokok}</p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">Tunjangan</p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">: ${item.tunjangan}</p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">Potongan </p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">: ${item.potongan}</p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">Bonus </p></div>
                                                <div class="col-12 col-md-6"><p class="mb-0 fs-13 mt-3 text-dark">: ${item.bonus}</p></div>
                                                <div class="col-12"><p class="mb-0 fs-13 mt-3 fw-semibold text-dark">Total : ${item.total_gaji}</p></div>
                                                <div class="col-12"><p class="mb-0 fs-13 mt-3 fw-semibold text-dark">Metode Pembayaran : ${item.metode_pembayaran}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                    notificationList.append(notificationItem);
                });

                $('.view-image-btn').on('click', function () {
                    var filePath = $(this).data('file-path');
                    $('#modalImage').attr('src', filePath);
                    $('#imageModal').modal('show');
                });
            }
        });
    });
</script>

<?php include 'src/footer.php'; ?>
