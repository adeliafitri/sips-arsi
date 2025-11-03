@extends('layouts.admin.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pertanyaan Kuisioner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Data Pertanyaan Kuisioner</li>
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
                  <form action="{{ route('admin.rps') }}" method="GET">
                    <div class="input-group col-sm-5 mr-3">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                    </div>
                  </form>
                </div>
                {{-- <div class="col-sm-2">
                    <a href="{{ route('admin.kelaskuliah.create') }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> --}}
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>Nama Kuisioner</th>
                            <th>Kategori</th>
                            <th>Indikator</th>
                            <th>Pertanyaan</th>
                            <th style="width: 150px;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                                @php
                                    $rowCount = count($datas['pertanyaan']);
                                    $rowIndex = 0;
                                @endphp
                                @foreach ($datas['pertanyaan'] as $info)
                                    <tr>
                                        @if ($rowIndex == 0)
                                            <td rowspan="{{ $rowCount }}">{{ $startNumber++ }}</td>
                                            <td rowspan="{{ $rowCount }}">
                                                {{ $datas['nama_formulir'] }}
                                                <div class="mt-2">
                                                    <a href="{{ route('admin.surveyQuestion.create', ['id_form' => $datas['id_form']]) }}" class="btn-sm btn-primary">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Tambah Pertanyaan
                                                    </a>
                                                </div>
                                            </td>
                                        @endif
                                        <td>{{ $info['kategori'] ?? 'Tidak ada kategori' }}</td>
                                        <td>{{ $info['indikator'] ?? 'Tidak ada indikator' }}</td>
                                        <td>{{ $info['pertanyaan'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.surveyQuestion.edit', $info['id']) }}" class="btn btn-secondary mt-1 mr-2"><i class="nav-icon fas fa-edit"></i></a>
                                            <button class="btn btn-danger mt-1" onclick="deleteQuestion({{ $info['id'] }})"><i class="nav-icon fas fa-trash"></i></button>
                                        </div>
                                        </td>
                                    </tr>
                                    @php $rowIndex++; @endphp
                                @endforeach
                            @endforeach
                        {{-- @foreach ($data as $nama_formulir => $pertanyaanList)
                            @php
                                $rowCount = count($pertanyaanList);
                                $rowIndex = 0;
                            @endphp
                            @foreach ($pertanyaanList as $info)
                                <tr>
                                    @if ($rowIndex == 0)
                                        <td rowspan="{{ $rowCount }}">{{ $startNumber++ }}</td>
                                        <td rowspan="{{ $rowCount }}">{{ $nama_formulir }}
                                            <div class="mt-2">
                                                <a href="{{ route('admin.surveyQuestion.create', [
                                            'id_form' => $datas->id
                                    ]) }}" class="btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-plus mr-2"></i> Tambah Pertanyaan
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                    <td>{{ $info['kategori'] ?? 'Tidak ada kategori'}}</td>
                                    <td>{{ $info['indikator'] ?? 'Tidak ada indikator' }}</td>
                                    <td>{{ $info['pertanyaan'] }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.surveyQuestion.edit', $info['id']) }}" class="btn btn-secondary mt-1 mr-2"><i class="nav-icon fas fa-edit"></i></a>
                                            <button class="btn btn-danger mt-1" onclick="deleteQuestion({{ $info['id'] }})"><i class="nav-icon fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @php $rowIndex++; @endphp
                            @endforeach
                        @endforeach --}}
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
       //content goes here
    });

          function deleteQuestion(id){
            Swal.fire({
            title: "Konfirmasi Hapus",
            text: "Apakah anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus"
            }).then((result) => {
              if (result.isConfirmed) {
                      $.ajax({
                      url: "{{ url('admin/survey-question') }}/" + id,
                      type: 'DELETE',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(response) {
                          if (response.status === 'success') {
                              console.log(response.message);

                              Swal.fire({
                              title: "Sukses!",
                              text: "Data berhasil dihapus",
                              icon: "success"
                              }).then((result) => {
                                  // Check if the user clicked "OK"
                                  if (result.isConfirmed) {
                                      // Redirect to the desired URL
                                      window.location.reload();
                                  };
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
        </script>
