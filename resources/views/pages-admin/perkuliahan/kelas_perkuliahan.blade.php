@extends('layouts.admin.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kelas Perkuliahan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Data Kelas Perkuliahan</li>
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
              <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-8">
                  <form action="{{ route('admin.kelaskuliah') }}" method="GET">
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
                <div class="dropdown col-sm-2">
                    <button class="btn btn-success w-100 dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-excel mr-2"></i> Excel
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#"><i class="fas fa-upload mr-2"></i> Export</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-download mr-2"></i> Import</a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a href="{{ route('admin.kelaskuliah.create') }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
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
                      <th style="width: 150px;">Tahun Ajaran</th>
                      <th style="width: 100px;">Semester</th>
                      <th>Mata Kuliah</th>
                      <th>Kelas</th>
                      <th>Dosen</th>
                      <th style="width: 100px;">Koordinator</th>
                      <th style="width: 100px;">Jumlah Mahasiswa</th>
                      <th style="width: 150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $key => $datas)
                    <tr>
                        <td>{{ $startNumber++ }}</td>
                        <td>{{ $datas->tahun_ajaran }}</td>
                        <td>{{ $datas->semester }}</td>
                        <td>{{ $datas->nama_matkul }}</td>
                        <td>{{ $datas->kelas }}</td>
                        <td>{{ $datas->nama_dosen }}</td>
                        <td>
                            <div class="row justify-content-center">
                                <form action="">
                                    <div class="form-group">
                                        {{-- <label for="toogleActive">Active</label> --}}
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="isActive" name="koordinator" {{ $datas->koordinator == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="isActive"></label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                        <td>{{ $datas->jumlah_mahasiswa }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.kelaskuliah.show', $datas->id) }}" class="btn btn-info mr-2"><i class="nav-icon far fa-eye"></i></a>
                                <a href="{{ route('admin.kelaskuliah.edit', $datas->id) }}" class="btn btn-secondary mr-2"><i class="nav-icon fas fa-edit"></i></a>
                                <form action="{{ route('admin.kelaskuliah.destroy', $datas->id) }}" method="post" class="">
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
              <!-- /.card-body -->

              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
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
