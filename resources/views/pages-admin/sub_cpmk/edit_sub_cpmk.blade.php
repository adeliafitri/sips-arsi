@extends('layouts.admin.main')

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Sub Capaian Pembelajaran Mata Kuliah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.subcpmk') }}">Data Sub CPMK</a></li>
              <li class="breadcrumb-item active">Edit Data</li>
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
                <h3 class="card-title col align-self-center">Form Edit Data Sub CPMK</h3>
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                </div> -->
              </div>
                <div class="card-body">
                <form action="{{ route('admin.subcpmk.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="form-group">
                    <label for="waktu_pelaksanaan">Minggu</label>
                    <input type="text" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" placeholder="Minggu Pelaksanaan" value="{{ $data->waktu_pelaksanaan }}">
                  </div>
                  <div class="form-group">
                    <label for="cpmk">CPMK</label>
                  <select class="form-control select2bs4" id="cpmk" name="cpmk">
                        <option value="">- Pilih CPMK -</option>
                        @foreach ($cpmk as $data_cpmk)
                            <option value="{{ $data_cpmk['id'] }}" {{ $data->cpmk_id == $data_cpmk['id'] ? 'selected' : '' }}>{{ $data_cpmk['kode_cpmk'] }} - {{ $data_cpmk['nama_matkul'] }}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="kode_subcpmk">Kode Sub CPMK</label>
                    <input type="text" class="form-control" id="kode_subcpmk" name="kode_subcpmk" placeholder="Kode Sub CPMK" value="{{ $data->kode_subcpmk }}">
                  </div>
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control text-muted" id="deskripsi" name="deskripsi" rows="3">
                      {{ $data->deskripsi }}
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label for="bentuk_soal">Bentuk Soal</label>
                    <input type="text" class="form-control" id="bentuk_soal" name="bentuk_soal" placeholder="Bentuk Soal" value="{{ $data->bentuk_soal }}">
                  </div>
                  <div class="form-group">
                    <label for="bobot">Bobot</label>
                    <input type="number" class="form-control" id="bobot" name="bobot_subcpmk" placeholder="Bobot" value="{{ $data->bobot_subcpmk }}">
                  </div>
                </div>
                 <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{ route('admin.subcpmk') }}" class="btn btn-default">Cancel</a>
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
