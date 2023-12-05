@extends('layouts.admin.main')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Kelas Perkuliahan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.kelaskuliah') }}">Data Kelas Perkuliahan</a></li>
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
              <h3 class="card-title col align-self-center">Form Tambah Data Kelas Perkuliahan</h3>
              <!-- <div class="col-sm-2">
                  <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
              </div> -->
            </div>
              <div class="card-body">
              <form action="{{ route('admin.kelaskuliah.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                      <select class="form-control select2bs4" id="kelas" name="kelas">
                      <option value="">- Pilih Kelas -</option>
                      @foreach ($kelas as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="mata_kuliah">Mata Kuliah</label>
                      <select class="form-control select2bs4" id="mata_kuliah" name="mata_kuliah">
                      <option value="">- Pilih Mata Kuliah -</option>
                      @foreach ($mata_kuliah as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="dosen">Dosen</label>
                      <select class="form-control select2bs4" id="dosen" name="dosen">
                      <option value="">- Pilih Dosen -</option>
                      @foreach ($dosen as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="tahun_ajaran">Tahun Ajaran</label>
                  <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Tahun Ajaran">
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label> <br>
                    <input type="radio" name="semester" value="Ganjil"> Ganjil
                    <input type="radio" name="semester" value="Genap"> Genap
                  </div>
               <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <a href="{{ route('admin.kelaskuliah') }}" class="btn btn-default">Cancel</a>
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
