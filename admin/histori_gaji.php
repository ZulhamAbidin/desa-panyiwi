<?php include 'src/header.php'; 

if (isset($_SESSION['success_message'])) {
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

if (isset($_SESSION['error_message'])) {
    echo '
    <script>
    $(document).ready(function() {
        var toastError = new bootstrap.Toast(document.getElementById("toastError"));
        $(".toast-body", toastError.element).text("' . $_SESSION['error_message'] . '");
        toastError.show();
    });
    </script>
    ';
    unset($_SESSION['error_message']);
}

$pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : 0;
?>

<div class="page-header">
    <h1 class="page-title">Histori Gaji Pegawai <span id="namaPegawai"></span></h1>
</div>


<div class="container">
    <ul class="notification" id="notificationList">
    </ul>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar Slip Gaji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Tidak Ada Gambar Bukti Pembayaran Karena Dilakukan Secara Otomatis" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var pegawai_id = '<?php echo $pegawai_id; ?>';
        $.ajax({
            url: 'controller/fetch_histori_gaji.php',
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

                    var fileButton = '';
                    if (item.file_path) {
                        fileButton = `<button type="button" class="btn btn-sm btn-primary view-image-btn" data-file-path="gambar/${item.file_path}"><i class="fa fa-eye"></i></button>`;
                    } else {
                        fileButton = `<button type="button" class="btn btn-sm btn-primary view-image-btn" data-file-path="gambar/default.jpg"><i class="fa fa-eye"></i></button>`;
                    }


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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<?php include 'src/footer.php'; ?>
