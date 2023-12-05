@extends('layouts.admin.main')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Mata Kuliah</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.matakuliah') }}">Data Mata Kuliah</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
              <div class="col-12 justify-content-center">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
              </div>
            <div class="card-header d-flex justify-content-end">
              <h3 class="card-title col align-self-center">Form Tambah Data Mata Kuliah</h3>
              <!-- <div class="col-sm-2">
                  <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
              </div> -->
            </div>
              <div class="card-body">
              <form action="{{ route('admin.matakuliah.store') }}" method="post" enctype="multipart/form-data">
                @CSRF
                <div class="form-group">
                  <label for="kode_matkul">Kode Matkul</label>
                  <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" placeholder="Kode Mata Kuliah">
                </div>
                <div class="form-group">
                  <label for="nama_matkul">Nama Matkul</label>
                  <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" placeholder="Nama Mata Kuliah">
                </div>
                <div class="form-group">
                  <label for="sks">SKS</label>
                  <input type="number" class="form-control" id="sks" name="sks" placeholder="SKS">
                </div>
              </div>
               <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <a href="{{ route('admin.matakuliah') }}" class="btn btn-default">Cancel</a>
                  <button type="submit" class="btn btn-primary">Save</button>
              </div>
              </form>
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
