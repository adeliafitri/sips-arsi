@extends('layouts.dosen.main')

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" alt="Logo Arsitektur UIN Maulana Malik Ibrahim Malang" height="60" width="60">
  </div>

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <br>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-9">
            @if ($semester == null)
                <p class="m-0 text-capitalize pt-1">Tidak ada tahun ajaran aktif</p>
            @else
            <p class="m-0 text-capitalize pt-1">Tahun Ajaran {{ $semester->tahun_ajaran . " " . $semester->semester }}</p>
            @endif
            </div><!-- /.col -->
            <div class="col-sm-3">
                <form id="filterForm" method="GET" action="{{ route('dosen.dashboard') }}">
                    <select class="form-control text-capitalize select2bs4" name="matkul_id" id="matkulSelect">
                        {{-- <option value="">Pilih Mata Kuliah</option> --}}
                        @foreach($mataKuliah as $matkul)
                            <option value="{{ $matkul->id }}"
                                {{ request('matkul_id') == $matkul->id ? 'selected' : '' }}>
                                {{ $matkul->nama_matkul }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- <div class="row"> -->
        <!-- Small boxes (Stat box) -->
    @if($data->isEmpty())
        <p>Tidak ada data untuk mata kuliah yang dipilih.</p>
    @else
    <div class="row">
        @php
            $colors = ['bg-info', 'bg-success', 'bg-warning'];
        @endphp
        @foreach ($data as $key => $datas)
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box {{ $colors[$key % count($colors)] }}">
              <div class="inner">
                <h4 class="text-capitalize">{{ $datas->nama_matkul }}</h4>
                <p><b>{{ $datas->kode_matkul }}</b></p>
                <p>Kelas {{ $datas->nama_kelas }}</p>
              </div>
              <div class="icon">
                <i class="fas fa-book-reader"></i>
              </div>
              <a href="{{ route('dosen.kelaskuliah.show', $datas->id_kelas) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        @endforeach
    </div>
    @endif
    <!-- /.row -->
      <!-- </div> -->
      <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between">
            <div class="align-self-center">
                <h5>Capaian Pembelajaran Lulusan (Angkatan)</h5>
            </div>
            <div>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter mr-2"></i> Filter Angkatan</button>
            </div>
            {{-- modal import --}}
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filter CPL Angkatan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="angkatanStart">Angkatan Mulai</label>
                                    <input type="number" class="form-control" id="angkatanStart" placeholder="2018">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="angkatanEnd">Angkatan Akhir</label>
                                    <input type="number" class="form-control" id="angkatanEnd" placeholder="2022">
                                </div>
                            </div>
                            <button id="applyFilter" class="btn btn-sm btn-primary">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix" id="chartsContainer"></div>
    <!-- RADAR CHART -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
            <h3 class="card-title text-capitalize">Capaian Pembelajaran Lulusan Semester</h3>
            <div class="float-right">
                <select class="form-control text-capitalize" id="semesterSelect">
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->tahun_ajaran }} {{ $semester->semester }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div> --}}
            </div>
            <div class="card-body">
            <canvas id="radarCPLSemesterDashboard" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
      <!-- /.row -->
      <!-- Main row -->
    <!-- Chart IKM -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">Indeks Kepuasan Mahasiswa (IKM)</h5>
                <h3>{{ $ikm_total }}</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="card-title">Indeks Kinerja Dosen (IKD)</h5>
                <h3>{{ $ikd_total }}</h3>
            </div>
        </div>
    </div>

    <!-- Chart IKD -->
    <div class="row">
        <div class="col-md-6">
            <h5>Hasil Survei IKM per Pertanyaan</h5>
            <canvas id="ikmChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5>Hasil Survei IKD per Pertanyaan</h5>
            <canvas id="ikdChart"></canvas>
        </div>
    </div>

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function() {
    // Survey Chart
    const ikmLabels = @json(array_column($perPertanyaan, 'pertanyaan'));
    const ikmScores = @json(array_column($perPertanyaan, 'skor'));

    const ikdLabels = @json(array_column($ikd_pertanyaan, 'pertanyaan'));
    const ikdScores = @json(array_column($ikd_pertanyaan, 'skor'));

    // Fungsi untuk potong label panjang
    function shortenLabel(label, maxLength = 30) {
        return label.length > maxLength ? label.substr(0, maxLength) + '…' : label;
    }

    // Chart IKM
    new Chart(document.getElementById('ikmChart'), {
        type: 'bar',
        data: {
            labels: ikmLabels,
            datasets: [{
                label: 'Skor IKM',
                data: ikmScores,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            // tooltip full pertanyaan
                            return context[0].label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index) {
                            let label = this.getLabelForValue(value);
                            return shortenLabel(label, 20);
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 5
                }
            }
        }
    });

    // Chart IKD
    new Chart(document.getElementById('ikdChart'), {
        type: 'bar',
        data: {
            labels: ikdLabels,
            datasets: [{
                label: 'Skor IKD',
                data: ikdScores,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index) {
                            let label = this.getLabelForValue(value);
                            return shortenLabel(label, 20);
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 5
                }
            }
        }
    });

    // Fetch data from the controller
    function chartSmtData(semesterId) {
        $.ajax({
            url: "{{ url('/dosen/dashboard/chart-cpl-smt') }}",
            type: 'GET',
            data: {
                semester_id: semesterId
            },
            success: function(response) {
                var ctx = document.getElementById('radarCPLSemesterDashboard').getContext('2d');
                var myRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Capaian Pembelajaran Lulusan',
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

    // Trigger saat semester diubah
    $('#semesterSelect').on('change', function() {
        var selectedSemesterId = $(this).val();
        chartSmtData(selectedSemesterId);
    });

    // Fetch data saat halaman pertama kali dimuat, menggunakan semester pertama dalam daftar
    var initialSemesterId = $('#semesterSelect').val();
    chartSmtData(initialSemesterId);

    // Function to fetch chart data
    function fetchChartData(startYear, endYear) {
        $.ajax({
            url: "{{ route('dosen.dashboard.chartcpl') }}",
            type: 'GET',
            data: {
                angkatan_start: startYear,
                angkatan_end: endYear
            },
            success: function(response) {
                $('#chartsContainer').empty(); // Kosongkan container sebelum menampilkan chart baru

                response.forEach(function(result) {
                    var chartId = 'radarCPLDashboard' + result.angkatan;
                    $('#chartsContainer').append('<div class="col-md-6"><div class="card card-info"><div class="card-header"><h3 class="card-title">Capaian Pembelajaran Lulusan Angkatan ' + result.angkatan + '</h3></div><div class="card-body"><canvas id="' + chartId + '" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas></div></div></div>');

                    var ctx = document.getElementById(chartId).getContext('2d');
                    new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: result.labels,
                            datasets: [{
                                label: 'Capaian Pembelajaran Lulusan Angkatan ' + result.angkatan,
                                data: result.values,
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
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // Event listener for filter button click
    $('#applyFilter').click(function() {
        var startYear = $('#angkatanStart').val();
        var endYear = $('#angkatanEnd').val();
        fetchChartData(startYear, endYear);
        $('#filterModal').modal('hide')
    });

    // Fetch default chart data on page load for current year and 3 years prior
    var currentYear = new Date().getFullYear();
    fetchChartData(currentYear - 3, currentYear);
    });

    $('#matkulSelect').on('change', function () {
        document.getElementById('filterForm').submit();
    });

</script>
@endsection
