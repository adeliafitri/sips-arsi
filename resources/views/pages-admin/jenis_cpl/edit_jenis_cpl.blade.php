@extends('layouts.admin.main')

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Jenis Capaian Pembelajaran Lulusan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.jeniscpl') }}">Data Jenis CPL</a></li>
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
                <h3 class="card-title col align-self-center">Form Edit Data Jenis CPL</h3>
              </div>
                <div class="card-body">
                <form action="{{ route('admin.jeniscpl.update', $data->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                    <label for="nama_jenis">Nama Jenis</label>
                    <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" placeholder="Nama Jenis" value="{{ $data->nama_jenis }}">
                    </div>
                </div>
                 <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{ route('admin.jeniscpl') }}" class="btn btn-default">Cancel</a>
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
