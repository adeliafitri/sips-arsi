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
              <li class="breadcrumb-item"><a href="{{ route('admin.kelaskuliah.show', $kelas_kuliah->id) }}">Detail Kelas Perkuliahan</a></li>
              <li class="breadcrumb-item active">Tambah Data Mahasiswa</li>
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
                    <h3 class="card-title col align-self-center">Form Tambah Daftar Mahasiswa</h3>
                    <!-- <div class="col-sm-2">
                        <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                    </div> -->
                </div>
                <form action="{{ route('admin.kelaskuliah.storemahasiswa', $kelas_kuliah->id) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                        <label for="mahasiswa">Mahasiswa</label>
                        <select class="form-control select2bs4" id="mahasiswa" name="mahasiswa" style="width: 100%;">
                            <option value="">- Pilih Mahasiswa -</option>
                            @foreach ($mahasiswa as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                        </select>
                        </div>
                    <div class="form-group">
                        <label for="kelas_matkul">Kelas Mata Kuliah</label>
                            <select class="form-control" disabled="disabled" id="kelas_matkul" name="kelas_matkul">
                            <option value="">- Pilih Kelas Mata Kuliah -</option>
                            @foreach ($matakuliah_kelas as $data_kelas)
                            <option value="{{ $data_kelas['id'] }}" {{ $kelas_kuliah->id == $data_kelas['id'] ? 'selected' : '' }}>{{ $data_kelas['kelas'] }} - {{ $data_kelas['nama_matkul'] }}</option>
                            @endforeach
                            </select>
                    </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('admin.kelaskuliah.show', $kelas_kuliah->id) }}" class="btn btn-default">Cancel</a>
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
