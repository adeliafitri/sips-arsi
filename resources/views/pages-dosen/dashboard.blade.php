@extends('layouts.dosen.main')

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" alt="Logo Arsitektur UIN Maulana Malik Ibrahim Malang" height="60" width="60">
  </div>

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
          @if ($semester == null)
            <p class="m-0 text-capitalize pt-1">Tidak ada tahun ajaran aktif</p>
          @else
          <p class="m-0 text-capitalize pt-1">Tahun Ajaran {{ $semester->tahun_ajaran . " " . $semester->semester }}</p>
          @endif
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- <div class="row"> -->
        <!-- Small boxes (Stat box) -->
    <div class="row">
        @php
            $colors = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
        @endphp
        @foreach ($data as $key => $datas)
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box {{ $colors[$key % count($colors)] }}">
              <div class="inner">
                <h4>{{ $datas->nama_matkul }}</h4>

                <p><b>{{ $datas->kode_matkul }}</b></p>
              </div>
              <div class="icon">
                <i class="fas fa-book-reader"></i>
              </div>
              <a href="{{ route('dosen.matakuliah.show', $datas->id_matkul) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        @endforeach
    </div>
    <!-- /.row -->
      <!-- </div> -->
      <div class="row">
        <!-- RADAR CHART -->
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                <h3 class="card-title">Capaian Pembelajaran Lulusan</h3>
                {{-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div> --}}
                <div class="card-tools">
                    <select id="selectAngkatan" class="form-control">
                        @foreach ($mahasiswa as $data)
                            <option value="{{ $data->angkatan }}">{{ $data->angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="card-body">
                <canvas id="radarCPLDashboard" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Function to fetch chart data
        function fetchChartData(angkatan) {
            $.ajax({
                url: "{{ route('dosen.dashboard.chartcpl') }}",
                type: 'GET',
                data: {
                    angkatan: angkatan // Send selected angkatan to the server
                },
                success: function(response) {
                    var ctx = document.getElementById('radarCPLDashboard').getContext('2d');
                    var myRadarChart = new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Capaian Pembelajaran Mata Kuliah',
                                data: response.values,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scale: {
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Event listener for dropdown change
        $('#selectAngkatan').change(function() {
            var selectedAngkatan = $(this).val();
            fetchChartData(selectedAngkatan);
        });

        // Trigger change event on page load to fetch initial data
        $('#selectAngkatan').trigger('change');
    });
</script>
@endsection
