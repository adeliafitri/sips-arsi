@extends('layouts.admin.main')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Admin</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.admins') }}">Data Admin</a></li>
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
              <h3 class="card-title col align-self-center">Form Tambah Data Admin</h3>
              <!-- <div class="col-sm-2">
                  <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
              </div> -->
            </div>
              <div class="card-body">
              <form id="addDataForm">
                @csrf
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="telp">Telp</label>
                    <input type="text" class="form-control" id="telp" name="telp" placeholder="08xxxx">
                </div>
                <div class="form-group">
                  <label for="role">Role</label>
                  {{-- <div class="col-12"> --}}
                    <select id="role" name="role" class="form-control" disabled>
                        <option>- Pilih Role -</option>
                        <option value="admin" selected>Admin</option>
                    </select>
                  {{-- </div> --}}
                </div>
              </div>
               <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <a href="{{ route('admin.admins') }}" class="btn btn-default">Batal</a>
                  <button type="button" class="btn btn-primary" onclick="addData()">Simpan</button>
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

@section('script')
  <script>
    function addData() {
        var form = $('#addDataForm');
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/data-admin/create') }}",
            data: form.serialize(),
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
                        window.location.href = "{{ route('admin.admins') }}";
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
