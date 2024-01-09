@extends('layouts.admin.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Dosen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Data Dosen</li>
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
              <div class="card-header d-flex col-md-12 justify-content-between">
                <div class="col-md-8">
                  <form action="{{ route('admin.dosen') }}" method="GET">
                    <div class="input-group col-md-4">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class=" col-md-4 d-flex align-items-end justify-content-end">
                  <div class="dropdown mr-4">
                      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-file-excel mr-2"></i> Excel
                      </button>
                      <div class="dropdown-menu">
                        <button class="dropdown-item" data-toggle="modal" data-target="#importExcelModal">
                            <i class="fas fa-upload mr-2"></i> Import Excel
                        </button>
                        <a class="dropdown-item" href="{{ route('admin.dosen.download-excel') }}"><i class="fas fa-download mr-2"></i> Download Format</a>
                      </div>
                  </div>
                  {{-- modal import --}}
                  <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importExcelModalLabel">Import Excel</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.dosen.import-excel') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="excelFile">Choose Excel File</label>
                                        <input type="file" class="form-control-file" id="excelFile" name="file" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div>
                      <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                  </div>
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
                      <th>NIDN</th>
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
                        <td>{{ $datas->nidn }}</td>
                        <td>{{ $datas->nama }}</td>
                        <td>{{ $datas->email }}</td>
                        <td>{{ $datas->telp }}</td>
                        <td class="d-flex">
                            {{-- <a href="{{ route('admin.dosen.show', $datas->id) }}" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> --}}
                            <a href="{{ route('admin.dosen.edit', $datas->id) }}" class="btn btn-secondary mt-1 mr-2"><i class="nav-icon fas fa-edit "></i></a>
                            <form action="{{ route('admin.dosen.destroy', $datas->id) }}" method="post" class="mt-1">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt "></i></button>
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
