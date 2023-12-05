@extends('layouts.admin.main')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Capaian Pembelajaran Lulusan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?include=data-cpl">Data CPL</a></li>
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
              <h3 class="card-title col align-self-center">Form Tambah Data CPL</h3>
              <!-- <div class="col-sm-2">
                  <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
              </div> -->
            </div>
              <div class="card-body">
              <form action="{{ route('admin.cpl.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="kode_cpl">Kode CPL</label>
                  <input type="text" class="form-control" id="kode_cpl" name="kode_cpl" placeholder="Kode CPL">
                </div>
                <div class="form-group">
                  <label for="jenis_cpl">Jenis CPL</label>
                  <div class="col-12">
                    <select id="jenis_cpl" name="jenis_cpl" class="form-control">
                        <option>- Pilih Jenis CPL -</option>
                        @foreach ($jenis_cpl as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="deskripsi">Deskripsi</label>
                  <textarea class="form-control text-muted" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi"></textarea>
                </div>
              </div>
               <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <a href="{{ route('admin.cpl') }}" class="btn btn-default">Cancel</a>
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
