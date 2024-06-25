                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © <span id="year"></span> <a href="javascript:void(0)">Keuangan</a> All
                        rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable()
            $('#example3').DataTable()
            $('#example4').DataTable()
            $('#example5').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        }

    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <!-- MULTI SELECT JS-->
    
    <script src="../sash/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../sash/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../sash/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="../sash/plugins/datatable/js/jszip.min.js"></script>
    <script src="../sash/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="../sash/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="../sash/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="../sash/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="../sash/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="../sash/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../sash/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="../sash/js/table-data.js"></script>
    <script src="../sash/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../sash/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../sash/js/sticky.js"></script>
    <script src="../sash/js/circle-progress.min.js"></script>
    <script src="../sash/plugins/peitychart/peitychart.init.js"></script>
    <script src="../sash/plugins/sidebar/sidebar.js"></script>
    <script src="../sash/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../sash/plugins/p-scroll/pscroll.js"></script>
    <script src="../sash/plugins/p-scroll/pscroll-1.js"></script>
    <script src="../sash/plugins/chart/Chart.bundle.js"></script>
    <script src="../sash/plugins/chart/rounded-barchart.js"></script>
    <script src="../sash/plugins/chart/utils.js"></script>

    <!-- <script src="../sash/plugins/select2/select2.full.min.js"></script> -->
    
    <script src="../sash/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../sash/js/apexcharts.js"></script>
    <script src="../sash/plugins/apexchart/irregular-data-series.js"></script>
    <script src="../sash/plugins/flot/chart.flot.sampledata.js"></script>
    <script src="../sash/plugins/sidemenu/sidemenu.js"></script>

    <script src="../sash/plugins/bootstrap5-typehead/autocomplete.js"></script>
    <script src="../sash/js/typehead.js"></script>
    <script src="../sash/js/index1.js"></script>

    <script src="../sash/js/themeColors.js"></script>
    <script src="../sash/js/custom.js"></script>
    <script src="../sash/js/circle-progress.min.js"></script>
    <script src="../sash/plugins/peitychart/peitychart.init.js"></script>
</body>
</html>