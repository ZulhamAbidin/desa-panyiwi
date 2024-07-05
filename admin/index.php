<?php
include 'src/header.php';
include '../koneksi.php';

function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

$queryDistinctYears = mysqli_query($koneksi, 'SELECT DISTINCT YEAR(periode) AS Year FROM laporan_keuangan ORDER BY Year DESC');
$dataDistinctYears = [];
while ($row = mysqli_fetch_array($queryDistinctYears)) {
    $dataDistinctYears[] = $row['Year'];
}
$tahunTerbaru = !empty($dataDistinctYears) ? max($dataDistinctYears) : date('Y');

$querySummary = mysqli_query(
    $koneksi,
    "
    SELECT 
        SUM(IF(YEAR(periode) = $tahunTerbaru, anggaran, 0)) AS total_anggaran,
        SUM(IF(YEAR(periode) = $tahunTerbaru, realisasi, 0)) AS total_realisasi
    FROM laporan_keuangan
",
);
$dataSummary = mysqli_fetch_array($querySummary);
$totalAnggaran = $dataSummary['total_anggaran'];
$totalRealisasi = $dataSummary['total_realisasi'];

$tahunTerbaru = mysqli_real_escape_string($koneksi, $tahunTerbaru);
$querySummarySelectedYear = mysqli_query(
    $koneksi,
    "
    SELECT 
        SUM(anggaran) AS total_anggaran_selected,
        SUM(realisasi) AS total_realisasi_selected,
        SUM(selisih) AS total_selisih_selected
    FROM laporan_keuangan
    WHERE YEAR(periode) = $tahunTerbaru
",
);
$dataSummarySelectedYear = mysqli_fetch_array($querySummarySelectedYear);
$totalAnggaranSelectedYear = $dataSummarySelectedYear['total_anggaran_selected'];
$totalRealisasiSelectedYear = $dataSummarySelectedYear['total_realisasi_selected'];
$totalSelisihSelectedYear = $dataSummarySelectedYear['total_selisih_selected'];
?>



<div class="container">

    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="form-group">
                <label for="tahunDropdown">Pilih Tahun:</label>
                <select class="form-control" id="tahunDropdown" onchange="updateChart()">
                    <?php
                    foreach ($dataDistinctYears as $year) {
                        $selected = $year == $tahunTerbaru ? 'selected' : '';
                        echo "<option value=\"$year\" $selected>$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="pt-4 fw-semibold">
                    <h5 class="text-center pt-4 fw-semibold">Total Kategori</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-center" id="totalKategori">Loading...</h2 class="text-center">
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="pt-4 fw-semibold">
                    <h5 class="text-center pt-4 fw-semibold">Total Data Operasional</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-center" id="totalDataKeuangan">Loading...</h2 class="text-center">
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="pt-4 fw-semibold">
                    <h5 class="text-center pt-4 fw-semibold">User Admin</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-center" id="userAdmin">Loading...</h2 class="text-center">
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="">Total Users</h6>
                            <h2 class="mb-0 number-font">44,278</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <div class="chartjs-size-monitor"
                                    style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand"
                                        style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                        </div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink"
                                        style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <canvas id="saleschart" class="h-8 w-9 chart-dropshadow chartjs-render-monitor"
                                    width="96" height="64"
                                    style="display: block; width: 96px; height: 64px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-secondary"><i
                                class="fe fe-arrow-up-circle  text-secondary"></i> 5%</span>
                        Last week</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="align-middle">Statistik Anggaran Dan Realisasi Angggaran</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartBar2" class="h-275"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="align-middle">Persentase Realisasi Terhadap Anggaran</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartPie" class="h-275"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="selectYear">Pilih Tahun:</label>
                <select class="form-control" id="selectYear">
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="align-middle">Gaji Pegawai</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartBar" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ok -->
<!-- baru -->


<script>
    let chartInstance = null;

    function fetchDataByYear(year) {
        fetch(`controller/fetch_dashboard.php?year=${year}`)
            .then(response => response.json())
            .then(data => {
                populateYearDropdown(data.years, year);
                drawChart(data.data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function drawChart(data) {
        const labels = data.period;
        const datasets = [];

        const employeeNames = Object.keys(data.pegawai);

        employeeNames.forEach((nama, index) => {
            let backgroundColor;
            switch (index % 7) {
                case 0:
                    backgroundColor = '#2B5F9B';
                    break;
                case 1:
                    backgroundColor = '#e74c3c';
                    break;
                case 2:
                    backgroundColor = '#f7b731';
                    break;
                case 3:
                    backgroundColor = '#09AD95';
                    break;
                case 4:
                    backgroundColor = '#343A40';
                    break;
                case 5:
                    backgroundColor = '#4ECC48';
                    break;
                case 6:
                    backgroundColor = '#1170E4';
                    break;
                default:
                    backgroundColor = '#2B5F9B';
            }

            datasets.push({
                label: nama,
                backgroundColor: backgroundColor,
                data: labels.map(label => data.pegawai[nama][label] || 0)
            });
        });

        const config = {
            type: 'bar',
            data: {
                labels: labels.map(label => label),
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Periode',
                            color: 'black'
                        },
                        ticks: {
                            color: 'black'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Gaji',
                            color: 'black'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + new Intl.NumberFormat().format(value);
                            },
                            color: 'black'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'black'
                        },
                        padding: {
                            top: 100,
                            bottom: 100
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat().format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        };

        const ctx = document.getElementById('chartBar').getContext('2d');
        if (chartInstance) {
            chartInstance.destroy();
        }
        chartInstance = new Chart(ctx, config);
    }

    function populateYearDropdown(years, defaultYear) {
        const selectYear = document.getElementById('selectYear');
        selectYear.innerHTML = '';

        years.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            selectYear.appendChild(option);
        });

        if (defaultYear) {
            selectYear.value = defaultYear;
        } else {
            selectYear.value = years[0];
        }
    }

    document.getElementById('selectYear').addEventListener('change', function() {
        const selectedYear = this.value;
        fetchDataByYear(selectedYear);
    });

    // Panggil pertama kali untuk mengisi dropdown dan data chart
    const currentYear = new Date().getFullYear();
    fetchDataByYear(currentYear);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('chartBar2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Anggaran',
                    backgroundColor: '#2B5F9B',
                    data: []
                }, {
                    label: 'Realisasi',
                    backgroundColor: '#f7b731',
                    data: []
                }, {
                    label: 'Selisih',
                    backgroundColor: '#e74c3c',
                    data: []
                }]

            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp ' + tooltipItem.yLabel.toLocaleString();
                        }
                    }
                }
            }
        });

        var ctxPie = document.getElementById('chartPie').getContext('2d');
        var myPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3'],
                datasets: [{
                    label: 'Persentase',
                    backgroundColor: ['#2ecc71', '#3498db',
                        '#e74c3c'
                    ],
                    data: [, , ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            var currentValue = data.datasets[tooltipItem.datasetIndex].data[
                                tooltipItem.index];

                            function formatRupiah(angka) {
                                var reverse = angka.toString().split('').reverse().join('');
                                var ribuan = reverse.match(/\d{1,3}/g);
                                ribuan = ribuan.join('.').split('').reverse().join('');
                                return 'Rp ' + ribuan;
                            }

                            return datasetLabel + ': ' + formatRupiah(currentValue);
                        }
                    }
                }

            }
        });

        function updateChart() {
            var selectedYear = $("#tahunDropdown").val();
            $.ajax({
                type: 'POST',
                url: 'ajax_update_chart.php',
                data: {
                    year: selectedYear
                },
                success: function(response) {
                    myChart.data.labels = response.labels;
                    myChart.data.datasets[0].data = response.anggaran;
                    myChart.data.datasets[1].data = response.realisasi;

                    var selisihData = response.selisih.map(function(value) {
                        return Math.abs(
                            value);
                    });
                    myChart.data.datasets[2].data = selisihData;

                    myChart.update();

                    myPieChart.data.labels = response.labels.slice(0,
                        5);
                    myPieChart.data.datasets[0].data = response.realisasi.slice(0,
                        5);
                    myPieChart.update();
                },

                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        updateChart();

        $("#tahunDropdown").on("change", function() {
            updateChart();
        });


        function loadDashboardData() {
            $.ajax({
                url: 'controller/get-dashboard.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#totalKategori').html(response.totalkategori);
                    $('#totalDataKeuangan').html(response.totaldatakeuangan);
                    $('#userAdmin').html(response.useradmin);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching dashboard data:', error);
                }
            });
        }

        loadDashboardData();

        $('#refreshDashboard').click(function() {
            loadDashboardData();
        });
    });
</script>
<?php include 'src/footer.php'; ?>
