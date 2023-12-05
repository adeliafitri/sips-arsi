@extends('layouts.admin.main')

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
              <li class="breadcrumb-item"><a href="{{ route('admin.kelaskuliah') }}">Data Kelas Perkuliahan</a></li>
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
            <p><span class="text-bold">Semester :</span> {{ $data->semester }}</p>
            <p><span class="text-bold">Tahun Ajaran :</span> {{ $data->tahun_ajaran }}</p>
            <p><span class="text-bold">Dosen :</span> {{ $data->nama_dosen }}</p>
            <p><span class="text-bold">Jumlah Mahasiswa(Aktif) :</span> 15</p>
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
                <div class="col-sm-2">
                    <a href="{{ route('admin.kelaskuliah.createmahasiswa', $data->id) }}" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div>
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
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Nilai Akhir</th>
                      <th>Keterangan</th>
                      <th style="width: 250px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($mahasiswa as $key => $mahasiswas)
                    <tr>
                        <td>{{ $startNumber++ }}</td>
                        <td>{{ $mahasiswas->nim }}</td>
                        <td>{{ $mahasiswas->nama }}</td>
                        <td>{{ $mahasiswas->nilai_akhir }}</td>
                        <td>Lulus</td>
                        <td>
                            <a href="{{ route('admin.kelaskuliah.nilaimahasiswa', ['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail Nilai</a>
                            <form action="{{ route('admin.kelaskuliah.destroymahasiswa',['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" method="post" class="mt-1">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</button>
                            </form>
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
                        {{ $mahasiswa->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
