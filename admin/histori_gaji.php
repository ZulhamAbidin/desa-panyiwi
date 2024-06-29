<?php include '../src/header.php'; 

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
?>

<div class="page-header">
    <h1 class="page-title">Histori Gaji Pegawai</h1>
    <!-- <div>
        <ol class="breadcrumb">
            <a href="tambah.php" class="btn btn-primary"><i class="fe fe-plus me-2"></i>Tambah Data Keuangan</a>
        </ol>
    </div> -->
</div>

<div class="card">
    <div class="card-body">
        <table id="historiGajiTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                    <th>ID</th>
                    <th>Pegawai ID</th>
                    <th>Gaji Pegawai ID</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="historiGajiTable">
            </tbody>
        </table>
    </div>
</div>

<script>
        $(document).ready(function(){
            $.ajax({
                url: 'controller/fetch_histori_gaji.php',
                type: 'GET',
                success: function(response){
                    $('#historiGajiTable').html(response);
                }
            });
        });
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<?php include '../src/footer.php'; ?>