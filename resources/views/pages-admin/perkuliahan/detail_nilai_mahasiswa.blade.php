@extends('layouts.admin.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Nilai Mahasiswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?include=nilai-mahasiswa">Data Nilai</a></li>
              <li class="breadcrumb-item active">Nilai Mahasiswa</li>
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
            <div class="col-6">
            <p><span class="text-bold">Nama :</span> {{ $data->nama }}</p>
            <p><span class="text-bold">NIM :</span> {{ $data->nim }}</p>
            <p><span class="text-bold">Nilai Akhir :</span> {{ $data->nilai_akhir }} <a href=""><i class="nav-icon fas fa-edit ml-2"></i></a></p>
            </div>
            <div class="col-3">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h6 class="box-title">Capaian CPMK Mahasiswa</h6>
                                </div>
                                <div class="box-body">
                                    <canvas id="radarCpmkMahasiswa" style="height: 100px; width:100px;"></canvas>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="downloadButton" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Unduh</button>
                            </div>
                        </div>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

            <div class="card">
              <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-10">
                  <form action="product.php?aksi=cari" method="post">
                    <div class="input-group col-sm-4 mr-3">
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
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=tambah-daftar-mahasiswa" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> -->
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Minggu</th>
                      <th>Nama Sub-CPMK</th>
                      <th>Bentuk Soal</th>
                      <th>Bobot Sub-CPMK</th>
                      <th>Nilai</th>
                      <th style="width: 250px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($nilai_subcpmk as $nilai)
                    <tr>
                        <td>{{ $startNumber++ }}</td>
                        <td>{{ $nilai->waktu_pelaksanaan }}</td>
                        <td>{{ $nilai->kode_subcpmk }}</td>
                        <td>{{ $nilai->bentuk_soal }}</td>
                        <td>{{ $nilai->bobot_subcpmk }}%</td>
                        <td>{{ $nilai->nilai }}</td>
                        <td>
                            <!-- <a href="index.php?include=detail-daftar-mahasiswa" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                            <a href="{{ route('admin.kelaskuliah.nilaimahasiswa.edit',['id'=> $data->matakuliah_kelasid, 'id_mahasiswa' => $data->mahasiswa_id, 'id_subcpmk' => $nilai->id]) }}" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a>
                            <!-- <a href="javascript:if(confirm('Anda yakin ingin menghapus data?')) window.location.href = 'index.php?include=detail-kelas-perkuliahan&notif=hapusberhasil'" class="btn btn-danger mt-1"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</a> -->
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $nilai_subcpmk->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
                </div>
            </div>
            <!-- /.card -->

            <h5 class="text-bold text-center">Nilai Berdasarkan Sub-CPMK</h5>
             <!-- /.card -->

             <div class="card">
               <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-10">
                  <form action="product.php?aksi=cari" method="post">
                    <div class="input-group col-sm-4 mr-3">
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
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=tambah-daftar-mahasiswa" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> -->
             </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>CPL</th>
                      <th>CPMK</th>
                      <th>Sub-CPMK</th>
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <!-- <th style="width: 250px;">Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sub_cpmk as $nilai_sub)
                    <tr>
                        <td>{{ $subNumber++ }}</td>
                        <td>{{ $nilai_sub->kode_cpl }}</td>
                        <td>{{ $nilai_sub->kode_cpmk }}</td>
                        <td>{{ $nilai_sub->kode_subcpmk }}</td>
                        <td>{{ $nilai_sub->bobot }}</td>
                        <td>
                            {{ $nilai_sub->nilai }}
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $sub_cpmk->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
                </div>
            </div>
            <!-- /.card -->

            <h5 class="text-bold text-center">Nilai Berdasarkan CPMK</h5>
             <!-- /.card -->

             {{-- <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>CPL</th>
                      <th>CPMK</th>
                      <!-- <th>Sub-CPMK</th> -->
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <!-- <th style="width: 250px;">Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cpmk as $nilai_cpmk)
                    <tr>
                        <td>{{ $cpmkNumber++ }}</td>
                        <td>{{ $nilai_cpmk->kode_cpl }}</td>
                        <td><{{ $nilai_cpmk->kode_cpmk }}</td>
                        <!-- <td>Sub-CPMK 2</td> -->
                        <td>{{ $nilai_cpmk->bobot }}%</td>
                        <td>{{ $nilai_cpmk->avg_nilai }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

               <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $cpmk->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
              </div>
            </div>
            <!-- /.card --> --}}

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
