@extends('layouts.dosen.main')

{{-- @section('form')
    @include('pages-dosen.mata_kuliah.partials.detail.detail_cpl')
@endsection --}}

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data RPS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
                <li class="breadcrumb-item active">Data RPS</li>
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
                  <form action="{{ route('dosen.matakuliah') }}" method="GET">
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
                {{-- <div class="col-sm-2">
                    <a href="{{ route('dosen.matakuliah.create.matkul') }}" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> --}}
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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Tahun RPS</th>
                            <th style="width: 150px;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $key => $datas)
                          <tr>
                              <td>{{ $startNumber++ }}</td>
                              <td>{{ $datas->kode_matkul }}</td>
                              <td>{{ $datas->nama_matkul }}</td>
                              <td>{{ $datas->sks }}</td>
                              <td>{{ $datas->semester }}</td>
                              <td>{{ $datas->tahun_rps }}</td>
                              <td class="d-flex justify-content-center">
                                  @if ($datas->koordinator == $dosen->id && $datas->status == 'aktif')
                                  <a class="btn btn-primary mr-1 linkPustaka" id="" data-id="{{ $datas->id_rps }}" data-toggle="tooltip" data-placement="top" title="Tambah data RPS" data-target="#modalPustaka{{ $datas->id_rps }}"><i class="nav-icon fas fa-plus"></i></a>
                                  {{-- <a href="{{ route('dosen.rps.create', $datas->id_rps) }}" class="btn btn-primary mr-1" data-toggle="tooltip" data-placement="top" title="Tambah data RPS"><i class="nav-icon fas fa-plus"></i></a> --}}
                                  @endif

                                  <!-- modal pustaka -->
                                  <div class="modal fade" id="modalPustaka{{ $datas->id_rps }}" tabindex="-1" role="dialog" aria-labelledby="modalPustakaLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalPustakaLabel">Form Data RPS (Informasi Tambahan)</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formPustaka">
                                                @csrf
                                                {{-- <input type="hidden" name="rps_id" value="{{ $datas->id_rps }}"> --}}
                                                <div class="form-group">
                                                    <label for="rumpun_mk">Rumpun Mata Kuliah</label>
                                                    <input type="text" name="rumpun_mk" id="rumpun_mk" class="form-control" value="{{ old('rumpun_mk', $datas->rumpun_mk) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="deskripsi_mk">Deskripsi Mata Kuliah</label>
                                                    <textarea name="deskripsi_mk" id="deskripsi_mk_{{ $datas->id_rps }}" rows="5" class="form-control ckeditor">{{ old('deskripsi_mk', $datas->deskripsi_mk) }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bahan_kajian">Bahan Kajian</label>
                                                    <textarea name="bahan_kajian" id="bahan_kajian_{{ $datas->id_rps }}" rows="5" class="form-control ckeditor">{{ old('bahan_kajian', $datas->bahan_kajian) }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pustaka">Pustaka</label>
                                                    <textarea name="pustaka" id="pustaka_{{ $datas->id_rps }}" rows="5" class="form-control ckeditor">{{ old('pustaka', $datas->pustaka) }}</textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-start">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-success" onclick="savePustaka({{ $datas->id_rps }})">Simpan</button>
                                            <a href="{{ route('dosen.rps.create', $datas->id_rps) }}" class="btn btn-warning">Lewati</a>
                                        </div>
                                        </div>
                                    </div>
                                   </div>
                                   <a href="{{ route('dosen.matakuliah.show', $datas->id_rps) }}" class="btn btn-info mr-1"><i class="nav-icon far fa-eye" ></i></a>
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
{{-- @section('JSMataKuliah') --}}
@section('script')

  <script>
    let editors = {};
    $(document).ready(function () {
        // Aktifkan tooltip
        // $('[data-toggle="tooltip"]').tooltip();

        // Handle klik secara manual untuk buka modal
        $('.linkPustaka').on('click', function (e) {
            e.preventDefault();
            const rpsId = $(this).data('id');
            $('#modalPustaka' + rpsId).modal('show');
        });

        // Inisialisasi CKEditor untuk semua textarea
        document.querySelectorAll('.ckeditor').forEach(textarea => {
            let id = textarea.id;
            ClassicEditor
                .create(textarea)
                .then(editor => {
                    editors[id] = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        });
        // $('.ckeditor').each(function () {
        //     ClassicEditor.create(this).catch(error => {
        //         console.error(error);
        //     });
        // });
    });

    function savePustaka(rpsId) {
        // const rpsId = $('input[name="rps_id"]').val();
        let bahanKajianId = `bahan_kajian_${rpsId}`;
        let pustakaId = `pustaka_${rpsId}`;
        let deskripsiMkId = `deskripsi_mk_${rpsId}`;

        let bahanKajian = editors[bahanKajianId]?.getData() || '';
        let pustaka = editors[pustakaId]?.getData() || '';
        let deskripsiMk = editors[deskripsiMkId]?.getData() || '';

        $.ajax({
            url: "{{ url('dosen/rps/update-kajian-pustaka/') }}/" + rpsId,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                bahan_kajian: bahanKajian,
                pustaka: pustaka,
                deskripsi_mk: deskripsiMk,
                rumpun_mk: $('#rumpun_mk').val()
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan.',
                }).then(() => {
                    window.location.href = "{{ route('dosen.rps.create', ':id') }}".replace(':id', rpsId);
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                });
            }
        });
    }

    function tesload(){
              console.log('ted');
          }


  </script>
@endsection

{{-- @yield('JSDetailMataKuliah'); --}}

