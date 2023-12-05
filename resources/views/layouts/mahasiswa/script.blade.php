<?php
if (isset($_GET['data']) && isset($_GET['id_mahasiswa'])) {
    $id_kelas_kuliah = $_GET['data'];
    $id_mahasiswa = $_GET['id_mahasiswa'];

   // Ambil data untuk radar chart dari database
    $cpmk_mahasiswa = "SELECT `c`.`kode_cpmk`, AVG(`n`.`nilai`) as avg_nilai FROM `nilaimahasiswa` `n` INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id` INNER JOIN `cpmk` `c` ON `s`.`cpmk_id` = `c`.`id` WHERE `n`.`mahasiswa_id` = '$id_mahasiswa' AND `n`.`matakuliah_kelasid` = '$id_kelas_kuliah'  GROUP BY `c`.`id` ORDER BY `c`.`id`"; // Sesuaikan dengan query yang dibutuhkan
    $query_radar = mysqli_query($koneksi, $cpmk_mahasiswa);

    // print($query_radar);

    // Inisialisasi array untuk menyimpan data radar
    $data_radar = array();

    // Loop untuk membaca data dari database
    while ($row_radar = mysqli_fetch_assoc($query_radar)) {
    // Sesuaikan nama kolom dengan struktur tabel Anda
    $kode_cpmk = $row_radar['kode_cpmk']; // Misalnya, 'Capaian CPMK Mahasiswa'
    $avg_nilai = $row_radar['avg_nilai']; // Misalnya, nilai dari capaian CPMK

    // Tambahkan data ke array
    $data_radar[] = array('label' => $kode_cpmk, 'value' => $avg_nilai);
    // print_r($data_radar);
}
}

?>

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="./plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="./plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="./plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="./plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="./plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="./plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="./plugins/moment/moment.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="./plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="./plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets-admin/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./assets-admin/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="./assets-admin/js/pages/dashboard.js"></script>
<!-- Select2 -->
<script src="./plugins/select2/js/select2.full.min.js"></script>
<!-- bs-custom-file-input -->
<script src="./plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //upload file
    $(function () {
        bsCustomFileInput.init();
    });

    // Data yang akan ditampilkan di grafik radar
    // var data = {
    //     labels: ["CPMK1", "CPMK2", "CPMK3", "CPMK4", "CPMK5"],
    //     datasets: [
    //         {
    //             label: "Data Nilai Tugas di Kelas",
    //             backgroundColor: "rgba(60,141,188,0.2)",
    //             borderColor: "rgba(60,141,188,1)",
    //             pointBackgroundColor: "rgba(60,141,188,1)",
    //             pointBorderColor: "#fff",
    //             pointHoverBackgroundColor: "#fff",
    //             pointHoverBorderColor: "rgba(60,141,188,1)",
    //             data: [88.7, 85, 90, 81, 56]
    //         },
    //         // {
    //         //     label: "Data Set 2",
    //         //     backgroundColor: "rgba(210, 214, 222, 0.2)",
    //         //     borderColor: "rgba(210, 214, 222, 1)",
    //         //     pointBackgroundColor: "rgba(210, 214, 222, 1)",
    //         //     pointBorderColor: "#fff",
    //         //     pointHoverBackgroundColor: "#fff",
    //         //     pointHoverBorderColor: "rgba(210, 214, 222, 1)",
    //         //     data: [28, 48, 40, 19, 96]
    //         // }
    //     ]
    // };

    // var radarChartCanvas = $("#radarChart").get(0).getContext("2d");

    // var radarChart = new Chart(radarChartCanvas, {
    //     type: "radar",
    //     data: data,
    //     options: {
    //         scale: {
    //             ticks: {
    //                 beginAtZero: true,
    //                 min: 0,       // Nilai minimum sumbu Y
    //                 max: 100,      // Nilai maksimum sumbu Y
    //                 stepSize: 20
    //             }
    //         }
    //     }
    // });

    // var radarChartCanvasSub = $("#radarChartSub").get(0).getContext("2d");

    // var radarChartSub = new Chart(radarChartCanvasSub, {
    //     type: "radar",
    //     data: data,
    //     options: {
    //         scale: {
    //             ticks: {
    //                 beginAtZero: true,
    //                 min: 0,       // Nilai minimum sumbu Y
    //                 max: 100,      // Nilai maksimum sumbu Y
    //                 stepSize: 20
    //             }
    //         }
    //     }
    // });

    // var radarChartCanvasCPMK = $("#radarChartCPMK").get(0).getContext("2d");

    // var radarChartCPMK = new Chart(radarChartCanvasCPMK, {
    //     type: "radar",
    //     data: data,
    //     options: {
    //         scale: {
    //             ticks: {
    //                 beginAtZero: true,
    //                 min: 0,       // Nilai minimum sumbu Y
    //                 max: 100,      // Nilai maksimum sumbu Y
    //                 stepSize: 20
    //             }
    //         }
    //     }
    // });

    // var radarChartCanvasCPL = $("#radarChartCPL").get(0).getContext("2d");

    // var radarChartCPL = new Chart(radarChartCanvasCPL, {
    //     type: "radar",
    //     data: data,
    //     options: {
    //         scale: {
    //             ticks: {
    //                 beginAtZero: true,
    //                 min: 0,       // Nilai minimum sumbu Y
    //                 max: 100,      // Nilai maksimum sumbu Y
    //                 stepSize: 20
    //             }
    //         }
    //     }
    // });

    // var radarChartCanvasMahasiswa = $("#radarChartMahasiswa").get(0).getContext("2d");

    // var radarChartCPL = new Chart(radarChartCanvasMahasiswa, {
    //     type: "radar",
    //     data: data,
    //     options: {
    //         scale: {
    //             ticks: {
    //                 beginAtZero: true,
    //                 min: 0,       // Nilai minimum sumbu Y
    //                 max: 100,      // Nilai maksimum sumbu Y
    //                 stepSize: 20
    //             }
    //         }
    //     }
    // });

  });

    $(function () {
    var radarData = <?php echo json_encode($data_radar); ?>;

    function drawChart(data) {
        var labels = data.map(item => item.label);
        var values = data.map(item => item.value);

        var radarCanvasCpmkMahasiswa = $("#radarCpmkMahasiswa").get(0).getContext("2d");

        var radarChart = new Chart(radarCanvasCpmkMahasiswa, {
            type: "radar",
            data: {
                labels: labels,
                datasets: [{
                    label: 'Capaian CPMK Mahasiswa',
                    backgroundColor: "rgba(60,141,188,0.2)",
                    borderColor: "rgba(60,141,188,1)",
                    pointBackgroundColor: "rgba(60,141,188,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(60,141,188,1)",
                    data: values
                }]
            },
            options: {
                scale: {
                    ticks: {
                        beginAtZero: true,
                        min: 0,       // Nilai minimum sumbu Y
                        max: 100,      // Nilai maksimum sumbu Y
                        stepSize: 20
                    }
                }
            }
        });
    }

    drawChart(radarData);
    });

  // Tangani klik tombol unduh
    document.getElementById("downloadButton").addEventListener("click", function () {
    // Dapatkan referensi ke elemen canvas yang berisi grafik radar
    var radarCanvas = document.getElementById("radarCpmkMahasiswa");

    // Buat tautan unduh
    var downloadLink = document.createElement("a");
    downloadLink.href = radarCanvas.toDataURL("image/png");
    downloadLink.download = "grafik_radar.png";

    // Klik tautan unduh
    downloadLink.click();
});
  </script>
