@extends('layouts.dosen.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelas {{ $data->kelas }} - {{ $data->nama_matkul }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dosen.kelaskuliah') }}">Data Kelas Perkuliahan</a></li>
              <li class="breadcrumb-item active">{{ $data->kelas }} - {{ $data->nama_matkul }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Kelas</h3>

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
            <div class="row d-flex">
                <div class="col-sm-10">
                    <p><span class="text-bold">Semester :</span> {{ $data->semester }}</p>
                    <p><span class="text-bold">Tahun Ajaran :</span> {{ $data->tahun_ajaran }}</p>
                    <p><span class="text-bold">Dosen :</span> {{ $data->nama_dosen }}</p>
                    <p><span class="text-bold">Jumlah Mahasiswa(Aktif) :</span> {{ $jumlah_mahasiswa->jumlah_mahasiswa }}</p>
                </div>
                <div class="col-sm-2">
                    <a href="" class="btn btn-sm btn-info w-100"><i class="nav-icon fas fa-upload mr-2"></i> Upload File</a>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
            <div class="card">
              <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-sm-7">
                  <form action="{{ route('dosen.kelaskuliah.show', $data->id) }}" method="GET">
                    <div class="input-group col-sm-6 mr-3">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- <h3 class="card-title col align-self-center">List Products</h3> -->
                <div class="col-sm-2">
                    <a href="{{ route('dosen.kelaskuliah.masukkannilai', $data->id) }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-pen mr-2"></i> Masukkan Nilai</a>
                </div>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                         Tambah Data Mahasiswa
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#"><i class="fas fa-download mr-2"></i> Unduh Format Excel</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-upload mr-2"></i> Impor Excel</a>
                      <div class="dropdown-divider"></div>
                      <a href="{{ route('dosen.kelaskuliah.createmahasiswa', $data->id) }}" class="dropdown-item"><i class="fas fa-plus mr-2"></i>Tambah Data Manual</a>
                    </div>
                </div>
                {{-- <div class="col-sm-2">
                    <a href="{{ route('dosen.kelaskuliah.createmahasiswa', $data->id) }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> --}}
              </div>
              <div class="card-body">
              <div class="col-sm-12 mt-3">
                @if (session('success'))
                    <div class="alert alert-success bg-success" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger bg-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
              </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nilai Akhir</th>
                            <th>Huruf</th>
                            <th>Keterangan</th>
                            <th >Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($mahasiswa as $key => $mahasiswas)
                          <tr>
                              <td>{{ $startNumber++ }}</td>
                              <td>{{ $mahasiswas->nim }}</td>
                              <td>{{ $mahasiswas->nama }}</td>
                              <td>
                                  <div id="nilai-akhir-{{ $mahasiswas->id_nilai }}">
                                      {{ $mahasiswas->nilai_akhir }}
                                      <i class="nav-icon fas fa-edit" onclick="editNilaiAkhir({{ $mahasiswas->id_nilai }})" style="cursor: pointer"></i>
                                  </div>
                                  <form action="{{ route('dosen.kelaskuliah.editnilaiakhir') }}" method="POST" class="d-flex justify-content-end fit-content ">
                                      @csrf
                                      <input type="hidden" name="id_nilai" value="{{ $mahasiswas->id_nilai }}">
                                      <input type="hidden" class="form-control" name="matakuliah_kelasid" value="{{ $data->id }}">
                                      <input type="hidden" class="form-control" name="mahasiswa_id" value="{{ $mahasiswas->id }}">
                                      <input type="number" step="0.01" id="edit-nilai-akhir-form-{{ $mahasiswas->id_nilai }}" class="form-control" name="nilai_akhir" value="{{ $mahasiswas->nilai_akhir }}" style="width: 75px; display: none;">
                                      <button style="display: none;" type="submit" id="edit-nilai-akhir-button-{{ $mahasiswas->id_nilai }}" class="ml-2 btn btn-sm btn-primary"><i class="fas fa-check"></i></button>
                                  </form>
                              </td>
                              <td>{{ $huruf[$mahasiswas->id] }}</td>
                              <td>{{ $keterangan[$mahasiswas->id] }}</td>
                              <td>
                                  <div class="d-flex">
                                      <a href="{{ route('dosen.kelaskuliah.nilaimahasiswa', ['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" class="btn btn-info mr-2"><i class="nav-icon far fa-eye"></i></a>
                                      <form action="{{ route('dosen.kelaskuliah.destroymahasiswa',['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" method="post">
                                          @csrf
                                          @method('delete')
                                          <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                                      </form>
                                  </div>
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $mahasiswa->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
              </div>
            </div>
            <!-- /.card -->

            <div class="row d-flex">
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card-title">Nilai Tugas Di Kelas</h3>
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
                          <canvas id="radarTugas" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card-title">Penguasaan Sub-CPMK Di Kelas</h3>

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
                          <canvas id="radarSubCPMK" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card-title">Penguasaan CPMK Di Kelas</h3>
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
                          <canvas id="radarCPMK" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card-title">Penguasaan CPL Di Kelas</h3>

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
                          <canvas id="radarCPL" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                </div>
            </div>
          </div>
      </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
<script>
    function editNilaiAkhir(id){
        document.getElementById('nilai-akhir-'+ id).style.display = 'none';
        document.getElementById('edit-nilai-akhir-button-'+ id).style.display = 'block';
        document.getElementById('edit-nilai-akhir-form-'+ id).style.display = 'block';
    }

    $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('dosen/kelas-kuliah/nilai/chart-tugas') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->id }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarTugas').getContext('2d');
                var myRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Nilai rata-rata tugas',
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
                                max: 100,
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('dosen/kelas-kuliah/nilai/chart-sub-cpmk') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->id }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarSubCPMK').getContext('2d');
                var myRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Nilai rata-rata Sub-CPMK',
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
                                max: 100,
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('dosen/kelas-kuliah/nilai/chart-cpmk') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->id }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarCPMK').getContext('2d');
                var myRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Nilai rata-rata CPMK',
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
                                max: 100,
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    $(document).ready(function() {
        // Fetch data from the controller
        $.ajax({
            url: "{{ url('dosen/kelas-kuliah/nilai/chart-cpl') }}",
            type: 'GET',
            data: {
                matakuliah_kelasid: {{ $data->id }},
            },
            success: function(response) {
                var ctx = document.getElementById('radarCPL').getContext('2d');
                var myRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Nilai rata-rata CPL',
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
                                max: 100,
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.log(error);
            },
        });
    });
</script>
@endsection




