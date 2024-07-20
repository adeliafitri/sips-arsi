@extends('layouts.admin.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Mahasiswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
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
                            <div class="col-md-8 p-0">
                                <form action="{{ route('admin.mahasiswa') }}" method="GET">
                                    <div class="input-group col-md-6 mr-3 p-0">
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- <h3 class="card-title col align-self-center">List Products</h3> -->
                            <div class="dropdown col-md-2">
                                <button class="btn btn-success w-100 dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-file-excel mr-2"></i> Excel
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.mahasiswa.download-excel') }}"><i class="fas fa-download mr-2"></i> Download Format</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#importExcelModal"><i class="fas fa-upload mr-2"></i> Import Excel</a>
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
                                            <div class="callout callout-info">
                                                {{-- <h5>I am an info callout!</h5> --}}
                                                <p>Pastikan tidak ada NIM yang sama</p>
                                                <p>Pastikan kolom No Telepon pada file excel sudah diisi menggunakan petik satu seperti berikut '081234567891'</p>
                                            </div>
                                            <form id="formImport" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="excelFile">Choose Excel File</label>
                                                    <input type="file" class="form-control-file" id="excelFile" name="file" required>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="addFile()">Upload</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-2">
                                <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                            </div> --}}
                            <div class="col-md-2 p-0">
                                <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary w-100"><i
                                        class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success bg-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger bg-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            {{-- <th>Email</th> --}}
                                            <th>No Telp</th>
                                            <th>Angkatan</th>
                                            {{-- <th>Image</th> --}}
                                            <th style="width: 150px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($data as $key => $datas)
                                                <td>{{ $startNumber++ }}</td>
                                                <td>{{ $datas->nim }}</td>
                                                <td>{{ $datas->nama }}</td>
                                                {{-- <td>{{ $datas->email }}</td> --}}
                                                <td>{{ $datas->telp }}</td>
                                                <td>{{ $datas->angkatan }}</td>
                                                {{-- <td>
                                <div class="text-center">
                                    <img src="{{ asset('storage/image/' . $datas->image) }}" class="img-thumbnail" style="max-width: 150px;" alt="">
                                </div>
                            </td> --}}
                                                <td class="d-flex justify-content-center">
                                                    {{-- <a href="{{ route('admin.mahasiswa.show', $datas->id) }}" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> --}}
                                                    <a href="{{ route('admin.mahasiswa.edit', $datas->id) }}" class="btn btn-secondary mt-1 mr-1"><i class="nav-icon fas fa-edit"></i></a>
                                                    <a class="btn btn-danger mt-1" onclick="deleteMahasiswa({{$datas->id_auth}})"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                    {{-- <form action="{{ route('admin.mahasiswa.destroy', $datas->id_auth) }}"
                                                        method="post" class="mt-1 ml-1"
                                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit"><i
                                                                class="nav-icon fas fa-trash-alt"></i></button>
                                                    </form> --}}
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
       //content goes here
    });

          function deleteMahasiswa(id){
            console.log(id);
            Swal.fire({
            title: "Konfirmasi Hapus",
            text: "Apakah anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus"
          }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                    url: "{{ url('admin/mahasiswa') }}/" + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log(response.message);

                            Swal.fire({
                            title: "Sukses!",
                            text: response.message,
                            icon: "success"
                            }).then((result) => {
                                // Check if the user clicked "OK"
                                if (result.isConfirmed) {
                                    // Redirect to the desired URL
                                    window.location.reload();
                                };
                                    // window.location.href = "{{ route('admin.kelas') }}";
                            });
                        } else {
                            console.log(response.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error during AJAX request:', error);
                    }
                });
            }
          });
        }
        function addFile() {
            // var form = $('#formImport');
            var form = $('#formImport')[0]; // Get the form element
            var formData = new FormData(form); // Create a FormData object
            $.ajax({
                type: 'POST',
                url: "{{ url('admin/mahasiswa/excel/import') }}",
                // data: form.serialize(),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success"
                    }).then((result) => {
                        // Check if the user clicked "OK"
                        if (result.isConfirmed) {
                            // Redirect to the desired URL
                            window.location.href = "{{ route('admin.mahasiswa') }}";
                        };
                    });
                    }
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 422) {
                        var errorMessage = xhr.responseJSON.message;
                        Swal.fire({
                        icon: "error",
                        title:"Validation Error",
                        text: errorMessage,
                    }).then((result) => {
                        // Check if the user clicked "OK"
                        if (result.isConfirmed) {
                            // Redirect to the desired URL
                            window.location.reload();
                        };
                    });
                    }
                    else{
                        var errorMessage = xhr.responseJSON.message;
                        Swal.fire({
                        icon: "error",
                        title:"Error!",
                        text: errorMessage,
                    }).then((result) => {
                        // Check if the user clicked "OK"
                        if (result.isConfirmed) {
                            // Redirect to the desired URL
                            window.location.reload();
                        };
                    });
                    }
                    // Handle error here
                    console.error(xhr.responseText);
                }
            });
        }
        </script>
@endsection
