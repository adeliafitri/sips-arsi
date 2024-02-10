@extends('layouts.mahasiswa.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profile User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Profile User</li>
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
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    {{ $data->role }}
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{ $data->nama }}</b></h2>
                        {{-- <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p> --}}
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li ><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> NIM: {{ $data->nim }}</li>
                          <li ><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{ $data->telp }}</li>
                        </ul>
                      </div>
                      <div class="col-5 text-right">
                        @php
                            $images = $data->image;
                            $defaultImage = 'default-150x150.png';
                        @endphp
                        @if($images && file_exists(public_path('storage/image/' . $images)))
                            <img src="{{ asset('storage/image/' . $images) }}" alt="user-avatar" class="img-circle img-fluid">
                        @else
                            <img src="{{ asset('dist/img/' . $defaultImage) }}" class="img-circle" alt="Default Image">
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="{{ route('mahasiswa.user.edit', ['id' => $data->id_auth]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                      </a>
                    </div>
                  </div>
                </div>
              </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection