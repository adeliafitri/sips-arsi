@extends('layouts.admin.main')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Capaian Pembelajaran Mata Kuliah</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.cpmk') }}">Data CPMK</a></li>
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
              <h3 class="card-title col align-self-center">Form Tambah Data CPMK</h3>
              <!-- <div class="col-sm-2">
                  <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
              </div> -->
            </div>
              <div class="card-body">
              <form action="{{ route('admin.cpmk.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="mata_kuliah">Mata Kuliah</label>
                      <select class="form-control select2bs4" id="mata_kuliah" name="mata_kuliah">
                        <option>- Pilih Mata Kuliah -</option>
                        @foreach ($mata_kuliah as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="cpl">CPL</label>
                      <select class="form-control select2bs4" id="cpl" name="cpl">
                        <option>- Pilih CPL -</option>
                        @foreach ($cpl as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="kode_cpmk">Kode CPMK</label>
                  <input type="text" class="form-control" id="kode_cpmk" name="kode_cpmk" placeholder="Kode CPMK">
                </div>
                <div class="form-group">
                  <label for="deskripsi">Deskripsi</label>
                  <textarea class="form-control text-muted" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>
                </div>
              </div>
               <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <a href="{{ route('admin.cpmk') }}" class="btn btn-default">Cancel</a>
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
