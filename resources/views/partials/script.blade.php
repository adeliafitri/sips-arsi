

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="/js/app.js"></script>


<script>
    $(document).ready(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
      tags: true
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
