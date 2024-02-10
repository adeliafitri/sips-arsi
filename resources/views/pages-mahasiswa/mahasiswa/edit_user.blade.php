@extends('layouts.mahasiswa.main')

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data mahasiswa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('mahasiswa.user', ['id' => $data->id_auth]) }}">Profile User</a></li>
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
                <h3 class="card-title col align-self-center">Form Edit Data mahasiswa</h3>
              </div>
                <div class="card-body">
                <form action="{{ route('mahasiswa.proses.edit', ['id' => $data->id_auth]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ $data->nama }}">
                    </div>
                    <div class="form-group">
                      <label for="telp">No Telepon</label>
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="No Telepon" value="{{ $data->telp }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control"  disabled id="email" rows="3" name="email" placeholder="Email" value="{{ $data->email }}">
                    </div>
                    <a href="{{ route('mahasiswa.user.changePass') }}" class="text-danger">Change Password</a>
                    {{-- <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" rows="3" name="password" placeholder="Password">
                    <small class="text-danger">Tidak wajib diisi jika tidak ingin mengubah password</small>
                    </div> --}}
                  </div>
                 <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{ route('mahasiswa.user', ['id' => $data->id_auth]) }}" class="btn btn-default">Cancel</a>
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
