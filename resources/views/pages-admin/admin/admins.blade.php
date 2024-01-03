@extends('layouts.admin.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Data Admin</li>
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
                <div class="col-10">
                  <form action="{{ route('admin.admins') }}" method="GET">
                    <div class="input-group col-sm-4 mr-3">
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
                <div class="col-sm-2">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
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
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No Telp</th>
                      <th style="width: 150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $key => $datas)
                    <tr>
                        <td>{{ $startNumber++ }}</td>
                        <td>{{ $datas->nama }}</td>
                        <td>{{ $datas->email }}</td>
                        <td>{{ $datas->telp }}</td>
                        <td>
                            <!-- <a href="index.php?include=detail-cpl" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                            <a href="{{ route('admin.admins.edit', $datas->id) }}" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a>
                            <form action="{{ route('admin.admins.destroy', $datas->id_auth) }}" method="post" class="mt-1">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</button>
                            </form>
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
