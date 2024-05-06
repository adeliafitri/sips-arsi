@extends('layouts.mahasiswa.main')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Nilai Mahasiswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?include=nilai-mahasiswa">Data Nilai</a></li>
            <li class="breadcrumb-item active">Nilai Mahasiswa</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

   <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Detail Nilai {{ $data->nama_matkul }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button> -->
              </div>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-9">
                    <p><span class="text-bold">Nama :</span> {{ $data->nama }}</p>
                    <p><span class="text-bold">NIM :</span> {{ $data->nim }}</p>
                    <p><span class="text-bold">Nilai Akhir :</span> {{ $data->nilai_akhir }} </p>
                    <div class="dropdown col-sm-2">
                        <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                             Lihat RPS
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#"><i class="fas fa-download mr-2"></i> Download PDF</a>
                          <div class="dropdown-divider"></div>
                          <a href="{{ route('mahasiswa.matakuliah.show', $data->id_matkul) }}" class="dropdown-item"><i class="fas fa-eye mr-2"></i>Hanya Lihat</a>
                        </div>
                    </div>
                  </div>
                  <div class="col-3">
                    <h5 class="text-bold">Suplementary File</h5>
                    <ul>
                        <li>Nama file <a href="" data-toggle="tooltip" data-placement="top" title="Download File"><i class="fas fa-file-pdf ml-2"></i></a></li>
                    </ul>
                    {{-- <div class="box box-primary">
                        <div class="box-header with-border">
                            <h6 class="box-title">Capaian CPMK Mahasiswa</h6>
                        </div>
                        <div class="box-body">
                            <canvas id="radarCpmkMahasiswa" style="height: 100px; width:100px;"></canvas>
                        </div>
                    </div> --}}
                    {{-- <div class="text-center">
                        <button id="downloadButton" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Unduh</button>
                    </div> --}}
                  </div>
                </div>
            </div>
          </div>

        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs justify-content-center" >
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" data-toggle="pill" href="#cpl-tab" aria-controls="cpl-tab" aria-selected="true" onclick="nilaiCpl({{ $data->matakuliah_kelasid }});" ><h6  style="font-weight: bold">Data CPL</h6></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab"  data-toggle="pill" href="#cpmk-tab" aria-controls="cpmk-tab" aria-selected="false" onclick="nilaiCpmk({{ $data->matakuliah_kelasid }});"><h6 style="font-weight: bold">Data CPMK</h6></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content bg-white px-3">
                    <div class="tab-pane show fade active justify-content-center" id="cpl-tab" role="tabpanel">
                        <div id="nilai_cpl">
                        </div>
                    </div>

                    <div class="tab-pane fade justify-content-center" id="cpmk-tab" role="tabpanel">
                        <div id="nilai_cpmk">
                        </div>
                    </div>
                </div>
            </div>
        </div>

          <div class="row d-flex">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Capaian Pembelajaran Lulusan</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button> -->
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="radarCPLMahasiswa" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Capaian Pembelajaran Mata Kuliah</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button> -->
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="radarCPMKMahasiswa" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')

<script>
  function nilaiCpl(matakuliah_kelasid, mahasiswa_id){
    $.ajax({
            url: "{{ url('mahasiswa/kelas-kuliah/nilai/cpl') }}",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                matakuliah_kelasid: matakuliah_kelasid,
                mahasiswa_id: mahasiswa_id
            },
            success: function(data) {
            // Insert the table into the #cpl-tab element
            $('#nilai_cpl').html(data);

            },
            error: function(error) {
                console.log(error);
            }
        });
  }

  function nilaiCpmk(matakuliah_kelasid, mahasiswa_id){
    $.ajax({
            url: "{{ url('mahasiswa/kelas-kuliah/nilai/cpmk') }}",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                matakuliah_kelasid: matakuliah_kelasid,
                mahasiswa_id: mahasiswa_id
            },
            success: function(data) {
            // Insert the table into the #cpl-tab element
            $('#nilai_cpmk').html(data);

            },
            error: function(error) {
                console.log(error);
            }
        });
  }

  $(document).ready(function() {
    console.log('tes');
    nilaiCpl({{ $data->matakuliah_kelasid }}, {{ $data->mahasiswa_id }});
  });

  $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('mahasiswa/kelas-kuliah/nilai/chart-cpl') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->matakuliah_kelasid }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarCPLMahasiswa').getContext('2d');
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
    });

    $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('mahasiswa/kelas-kuliah/nilai/chart-cpmk') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->matakuliah_kelasid }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarCPMKMahasiswa').getContext('2d');
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
    });
</script>
@endsection

