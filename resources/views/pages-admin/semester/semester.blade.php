@extends('layouts.admin.main')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Semester</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Data Semester</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

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
                  <div>
                      <a href="{{ route('admin.semester.create') }}" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
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
                      <th> Tahun Ajaran </th>
                      <th> Semester </th>
                      <th> Aktif </th>
                      <th style="width: 150px;"> Action </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $i => $datas )
                      <tr>
                        <td class=""> {{ $startNumber }} </td>
                        <td> {{ $datas->tahun_ajaran }} </td>
                        <td>{{ ucfirst($datas->semester) }}</td>
                        {{-- <td> {{ $datas->is_active }} </td> --}}
                        <td>
                          <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn {{ $datas->is_active == '1' ? 'btn-primary' : 'btn-outline-primary' }}" onclick="changeIsActive({{ $datas->id }},'1')">
                              Ya
                            </label>
                            <label class="btn {{ $datas->is_active == '0' ? 'btn-primary' : 'btn-outline-primary' }}" onclick="changeIsActive({{ $datas->id }},'0')">
                              Tidak
                            </label>
                          </div>
                        </td>
                        <td class="d-flex">
                          <div>

                            <a href="{{ route('admin.semester.edit', $datas->id) }}" class="btn btn-secondary mt-1 mr-2"><i class="nav-icon fas fa-edit"></i></a>
                          </div>
                          <form action="{{ route('admin.semester.destroy', $datas->id) }}" method="post" class="mt-1">
                              @csrf
                              @method('delete')
                              <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                          </form> 
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                 </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
    
<script>
document.addEventListener('DOMContentLoaded', function () {
   //content goes here
});

      function changeIsActive(id, value){
        console.log(id, value);
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!"
      }).then((result) => {
        if (result.isConfirmed) {
                $.ajax({
                url: "{{ url('admin/semester/update-active') }}/" + id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    is_active: value
                },
                success: function(data) {
                    console.log('success');
                    Swal.fire({
                      title: "Deleted!",
                      text: "Your file has been deleted.",
                      icon: "success"
                    });
                    window.location.href = "{{ route('admin.semester') }}";
                },
                error: function(error) {
                    console.log(error);
                }
            });

          
        }
      });
        
      }
    </script>
