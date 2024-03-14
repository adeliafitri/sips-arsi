@extends('layouts.admin.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Mata Kuliah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.matakuliah') }}">Data Mata Kuliah</a></li>
                        <li class="breadcrumb-item active">Tambah Data RPS</li>
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
                            @if ($errors->any())
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
                            <h3 class="card-title col align-self-center">Form Tambah Data RPS</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div id="stepper1" class="bs-stepper">
                                    <div class="bs-stepper-header">
                                        <div class="step" data-target="#test-l-1">
                                            <button type="button" class="btn step-trigger">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">First step</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-2">
                                            <button type="button" class="btn step-trigger">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Second step</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-3">
                                            <button type="button" class="btn step-trigger">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">Third step</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="bs-stepper-content">
                                        <div id="test-l-1" class="content">
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
                                            <form action="{{ route('admin.rps.storecpmk', $matkul->id) }}" method="post" enctype="multipart/form-data" id="myFormCpmk">
                                                @csrf
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_cpl">Pilih CPL</label>
                                                    <select class="form-select w-100 mb-1" style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;" onfocus="this.style.borderColor = '#80bdff';" onblur="this.style.borderColor = '#939ba2';" aria-label="Default select example" id="cpl_id" name="cpl_id">
                                                        <option selected>-- Pilih CPL --</option>
                                                        @foreach ($cpl as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_cpmk">Kode CPMK</label>
                                                    <input type="text" class="form-control" id="kode_cpmk" name="kode_cpmk" placeholder="Kode CPMK">
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi_cpmk" name="deskripsi_cpmk" style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required></textarea>
                                                </div>

                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="submit" id="tambah-cpmk"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                </div>
                                            </form>
                                            <table class="table table-bordered" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th>Kode CPL</th>
                                                        <th>Kode CPMK</th>
                                                        <th>Deskripsi</th>
                                                        <th style="width: 150px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data_cpmk as $key => $datas)
                                                    <tr>
                                                        <td>{{ $start_nocpmk++ }}</td>
                                                        <td>{{ $datas->cpl_id }}</td>
                                                        <td>{{ $datas->kode_cpmk }}</td>
                                                        <td>{{ $datas->deskripsi }}</td>
                                                        <td class="d-flex justify-content-center">
                                                            <!-- <a href="index.php?include=detail-kelas" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->

                                                            <button class="btn btn-secondary mt-1 mr-1 btn-edit-cpmk" onclick="editCpmk({{ $datas->id }})"><i class="nav-icon fas fa-edit"></i></button>
                                                            <a class="btn btn-danger mt-1" onclick="deleteCpmk({{$datas->id}})"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                            {{-- <form action="{{ route('admin.kelas.destroy', $datas->id) }}" method="post" class="mt-1">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger ml-1" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-2" class="content">
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
                                            <form action="{{ route('admin.rps.storesubcpmk', $matkul->id) }}" method="post" enctype="multipart/form-data" id="myFormSubCpmk">
                                                @csrf
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_cpmk">Pilih CPMK</label>
                                                    <select class="form-select w-100 mb-1"
                                                        style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                        onfocus="this.style.borderColor = '#80bdff';"
                                                        onblur="this.style.borderColor = '#939ba2';"
                                                        aria-label="Default select example" id="pilih_cpmk" name="pilih_cpmk">
                                                        <option selected>-- Pilih CPMK --</option>
                                                        @foreach ($kode_cpmk as $key => $data)
                                                            <option value="{{ $key }}">{{ $data }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_subcpmk">Kode Sub CPMK</label>
                                                    <input type="text" class="form-control" id="kode_subcpmk"
                                                        name="kode_subcpmk" placeholder="Kode Sub CPMK">
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi_subcpmk" name="deskripsi_subcpmk"
                                                        style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px"
                                                        required></textarea>
                                                </div>

                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="submit" id="tambah-subcpmk"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="button" id="simpan-subcpmk-edit" style="display: none" onclick="saveEditedSubCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                </div>
                                            </form>
                                            <table class="table table-bordered" id="dataTable2">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th>Kode CPMK</th>
                                                        <th>Kode Sub CPMK</th>
                                                        <th>Deskripsi</th>
                                                        <th style="width: 150px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data_subcpmk as $values)
                                                    <tr>
                                                        <td>{{ $start_nosubcpmk++ }}</td>
                                                        <td>{{ $values->kode_cpmk }}</td>
                                                        <td>{{ $values->kode_subcpmk }}</td>
                                                        <td>{{ $values->deskripsi }}</td>
                                                        <td class="d-flex justify-content-center">
                                                            <!-- <a href="index.php?include=detail-kelas" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                                                            <button class="btn btn-secondary mt-1 mr-1 btn-edit-subcpmk" onclick="editSubCpmk({{ $values->id }})"><i class="nav-icon fas fa-edit"></i></button>
                                                            <a class="btn btn-danger mt-1" onclick="deleteSubCpmk({{$values->id}})"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                            {{-- <form action="{{ route('admin.kelas.destroy', $datas->id) }}" method="post" class="mt-1">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger ml-1" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-3" class="content">
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
                                            <form action="{{ route('admin.rps.storesoal', $matkul->id) }}" method="post" enctype="multipart/form-data" id="myFormSoal">
                                                @csrf
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_subcpmk">Pilih Sub CPMK</label>
                                                    <select class="form-select w-100 mb-1"
                                                        style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                        onfocus="this.style.borderColor = '#80bdff';"
                                                        onblur="this.style.borderColor = '#939ba2';"
                                                        aria-label="Default select example" id="pilih_subcpmk" name="pilih_subcpmk">
                                                        <option selected>-- Pilih Sub CPMK --</option>
                                                        @foreach ($kode_subcpmk as $subcpmkid => $value)
                                                                <option value="{{ $subcpmkid }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="bentuk_soal">Bentuk Soal</label>
                                                    <select class="form-control select2bs4" id="bentuk_soal" name="bentuk_soal" style="resize: none; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required>
                                                        @foreach ($data_soal as $soalid => $soal)
                                                            <option value="{{ $soalid }}">{{ $soal}}</option>
                                                        @endforeach
                                                    </select>
                                                    {{-- <textarea id="bentuk_soal" name="bentuk_soal" style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required></textarea> --}}
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="bobot">Bobot</label>
                                                        <div class="input-group mb-3">
                                                            <input id="bobot" type="number" class="form-control"
                                                                placeholder="Bobot" aria-label="Bobot"
                                                                aria-describedby="basic-addon2" name="bobot">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                                        <div class="input-group mb-3">
                                                            <input id="waktu_pelaksanaan" type="number" class="form-control"
                                                                aria-describedby="basic-addon2" name="waktu_pelaksanaan" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="submit" id="tambah-soalsubcpmk"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="button" id="simpan-soalsubcpmk-edit" style="display: none" onclick="saveEditedSubCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                </div>
                                            </form>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th>Kode Sub CPMK</th>
                                                        <th>Bentuk Soal</th>
                                                        <th>Bobot</th>
                                                        <th>Waktu Pelaksanaan</th>
                                                        <th style="width: 150px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data_soalsubcpmk as $unique => $contents)
                                                    <tr>
                                                        <td>{{ $start_nosoalsubcpmk++ }}</td>
                                                        <td>{{ $contents->kode_subcpmk }}</td>
                                                        <td>{{ $contents->bentuk_soal }}</td>
                                                        <td>{{ $contents->bobot_soal }}</td>
                                                        <td>{{ $contents->waktu_pelaksanaan }}</td>
                                                        <td class="d-flex justify-content-center">
                                                            <!-- <a href="index.php?include=detail-kelas" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                                                            <button class="btn btn-secondary mt-1 mr-1 btn-edit-soalsubcpmk" onclick="editSoalSubCpmk({{ $contents->id }})"><i class="nav-icon fas fa-edit"></i></button>
                                                            <a class="btn btn-danger mt-1" onclick="deleteSoal({{$contents->id}})"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                            {{-- <form action="{{ route('admin.kelas.destroy', $datas->id) }}" method="post" class="mt-1">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger ml-1" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="dist/js/bs-stepper.js"></script>
                        <script>
                            var stepper1Node = document.querySelector('#stepper1');
                            var stepper1 = new Stepper(document.querySelector('#stepper1'));
                            var saveAndNextBtn = document.getElementById('saveAndNextBtn');

                            stepper1Node.addEventListener('show.bs-stepper', function(event) {
                                console.warn('show.bs-stepper', event);
                                // Simpan langkah saat ini sebelum langkah baru ditampilkan
                                var currentStep = stepper1Node.querySelector('.bs-stepper-pane.active').getAttribute('data-bs-target');
                                simpanLangkahSaatIni(currentStep);
                            });
                            stepper1Node.addEventListener('shown.bs-stepper', function(event) {
                                console.warn('shown.bs-stepper', event);
                            });

                            document.addEventListener('DOMContentLoaded', function () {
                            //content goes here
                            });

                                function deleteCpmk(id){
                                    console.log(id);
                                    Swal.fire({
                                    title: "Are you sure?",
                                    text: "You won't be able to revert this!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes, delete it!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                            $.ajax({
                                            url: "{{ url('admin/rps/deletecpmk') }}/" + id,
                                            type: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    console.log(response.message);

                                                    Swal.fire({
                                                    title: "Deleted!",
                                                    text: "Your file has been deleted.",
                                                    icon: "success"
                                                    }).then((result) => {
                                                        // Check if the user clicked "OK"
                                                        if (result.isConfirmed) {
                                                            // Redirect to the desired URL
                                                            // Perbarui langkah saat ini setelah berhasil menghapus data
                                                            var currentStep = dapatkanLangkahSaatIni();
                                                            navigasiLangkah(currentStep); // Kembali ke langkah saat ini
                                                        };
                                                            // window.location.href = "{{ route('admin.kelas') }}";
                                                    });
                                                } else {
                                                    console.log(response.message);
                                                    // Tampilkan notifikasi gagal
                                                    Swal.fire({
                                                        title: "Error!",
                                                        text: "An error occurred while deleting the file.",
                                                        icon: "error"
                                                    });
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error during AJAX request:', error);
                                                // Tampilkan notifikasi gagal
                                                Swal.fire({
                                                    title: "Error!",
                                                    text: "An error occurred while processing your request.",
                                                    icon: "error"
                                                });
                                            }
                                        });
                                    }

                                });
                                }

                                function deleteSubCpmk(id){
                                    console.log(id);
                                    Swal.fire({
                                    title: "Are you sure?",
                                    text: "You won't be able to revert this!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes, delete it!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                            $.ajax({
                                            url: "{{ url('admin/rps/deletecpmk/sub') }}/" + id,
                                            type: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    console.log(response.message);

                                                    Swal.fire({
                                                    title: "Deleted!",
                                                    text: "Your file has been deleted.",
                                                    icon: "success"
                                                    }).then((result) => {
                                                        // Check if the user clicked "OK"
                                                        if (result.isConfirmed) {
                                                            // Perbarui langkah saat ini setelah berhasil menghapus data
                                                            var currentStep = dapatkanLangkahSaatIni();
                                                            navigasiLangkah(currentStep); // Kembali ke langkah saat ini
                                                        };
                                                            // window.location.href = "{{ route('admin.kelas') }}";
                                                    });
                                                } else {
                                                    console.log(response.message);
                                                    // Tampilkan notifikasi gagal
                                                    Swal.fire({
                                                        title: "Error!",
                                                        text: "An error occurred while deleting the file.",
                                                        icon: "error"
                                                    });
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error during AJAX request:', error);
                                                // Tampilkan notifikasi gagal
                                                Swal.fire({
                                                    title: "Error!",
                                                    text: "An error occurred while processing your request.",
                                                    icon: "error"
                                                });
                                            }
                                        });
                                    }
                                });
                                }

                                function deleteSoal(id){
                                    console.log(id);
                                    Swal.fire({
                                    title: "Are you sure?",
                                    text: "You won't be able to revert this!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes, delete it!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                            $.ajax({
                                            url: "{{ url('admin/rps/deletecpmk/sub/soal') }}/" + id,
                                            type: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    console.log(response.message);

                                                    Swal.fire({
                                                    title: "Deleted!",
                                                    text: "Your file has been deleted.",
                                                    icon: "success"
                                                    }).then((result) => {
                                                        // Check if the user clicked "OK"
                                                        if (result.isConfirmed) {
                                                            // Perbarui langkah saat ini setelah berhasil menghapus data
                                                            var currentStep = dapatkanLangkahSaatIni();
                                                            navigasiLangkah(currentStep); // Kembali ke langkah saat ini
                                                        };
                                                            // window.location.href = "{{ route('admin.kelas') }}";
                                                    });
                                                } else {
                                                    console.log(response.message);
                                                    // Tampilkan notifikasi gagal
                                                    Swal.fire({
                                                        title: "Error!",
                                                        text: "An error occurred while deleting the file.",
                                                        icon: "error"
                                                    });
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error during AJAX request:', error);
                                                // Tampilkan notifikasi gagal
                                                Swal.fire({
                                                    title: "Error!",
                                                    text: "An error occurred while processing your request.",
                                                    icon: "error"
                                                });
                                            }
                                        });
                                    }
                                });
                                }
                                    // Fungsi untuk menyimpan langkah saat ini di local storage
                                    function simpanLangkahSaatIni(langkah) {
                                        localStorage.setItem('langkahSaatIni', langkah);
                                    }

                                    // Fungsi untuk mendapatkan langkah saat ini dari local storage
                                    function dapatkanLangkahSaatIni() {
                                        return localStorage.getItem('langkahSaatIni');
                                    }

                                    // Fungsi untuk menavigasi antar langkah
                                    function navigasiLangkah(langkah) {
                                        var stepper1 = new Stepper(document.querySelector('#stepper1'));
                                        stepper1.to(langkah);
                                    }


                                    function editCpmk(id){

                                        $.ajax({
                                            url: "{{ url('admin/rps/editcpmk') }}/" + id,
                                            type: 'GET',
                                            success: function(response){
                                                $('#cpl_id').val(response.data.cpl_id);
                                                $('#kode_cpmk').val(response.data.kode_cpmk);
                                                $('#deskripsi_cpmk').val(response.data.deskripsi);
                                                // var form = document.getElementById('myFormCpmk');
                                                // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';

                                                // form.append(hiddenInputId);
                                                var form = document.getElementById('myFormCpmk');
                                                var hiddenInputId = document.createElement('input');
                                                hiddenInputId.type = 'hidden';
                                                hiddenInputId.name = 'cpmk_id';
                                                hiddenInputId.value = response.data.id;

                                                form.appendChild(hiddenInputId);

                                            },
                                            error: function(xhr){
                                                console.log(xhr.responseText);
                                            }
                                        });
                                        document.getElementById('tambah-cpmk').style.display = 'none';
                                        document.getElementById('simpan-cpmk-edit').style.display = 'block';
                                    };

                                    function saveEditedCpmk() {
                                    // Mendapatkan nilai input dari form atau elemen lainnya
                                    var form = $('#myFormCpmk');

                                    // Melakukan permintaan AJAX untuk menyimpan data yang diedit
                                    $.ajax({
                                        url: "{{ url('admin/rps/updatecpmk') }}", // URL untuk menyimpan data yang diedit
                                        type: 'PUT', // Metode HTTP untuk menyimpan data
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                        contentType: 'application/json', // Tipe konten yang dikirimkan dalam permintaan
                                        data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
                                        success: function(response){
                                            // Handle success response
                                            console.log('Data berhasil diperbarui:', response);
                                            // Misalnya, Anda dapat menampilkan pesan sukses kepada pengguna
                                        },
                                        error: function(xhr){
                                            // Handle error response
                                            console.log('Terjadi kesalahan:', xhr.responseText);
                                            // Misalnya, Anda dapat menampilkan pesan kesalahan kepada pengguna
                                        }
                                    });
                                    }

                                    function editSubCpmk(id){
                                    $.ajax({
                                        url: "{{ url('admin/rps/editsubcpmk') }}/" + id,
                                        type: 'GET',
                                        success: function(response){
                                            $('#pilih_cpmk').val(response.data.cpmk_id);
                                            $('#kode_subcpmk').val(response.data.kode_subcpmk);
                                            $('#deskripsi_subcpmk').val(response.data.deskripsi);
                                            // var form = document.getElementById('myFormCpmk');
                                            // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';

                                            // form.append(hiddenInputId);
                                            var form = document.getElementById('myFormSubCpmk');
                                            var hiddenInputId = document.createElement('input');
                                            hiddenInputId.type = 'hidden';
                                            hiddenInputId.name = 'subcpmk_id';
                                            hiddenInputId.value = response.data.id;

                                            form.appendChild(hiddenInputId);

                                        },
                                        error: function(xhr){
                                            console.log(xhr.responseText);
                                        }
                                    });
                                    document.getElementById('tambah-subcpmk').style.display = 'none';
                                    document.getElementById('simpan-subcpmk-edit').style.display = 'block';
                                    };

                                    function saveEditedSubCpmk() {
                                    // Mendapatkan nilai input dari form atau elemen lainnya
                                    var form = $('#myFormSubCpmk');

                                    // Melakukan permintaan AJAX untuk menyimpan data yang diedit
                                    $.ajax({
                                        url: "{{ url('admin/rps/updatesubcpmk') }}", // URL untuk menyimpan data yang diedit
                                        type: 'PUT', // Metode HTTP untuk menyimpan data
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                        contentType: 'application/json', // Tipe konten yang dikirimkan dalam permintaan
                                        data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
                                        success: function(response){
                                            // Handle success response
                                            console.log('Data berhasil diperbarui:', response);
                                            // Misalnya, Anda dapat menampilkan pesan sukses kepada pengguna
                                        },
                                        error: function(xhr){
                                            // Handle error response
                                            console.log('Terjadi kesalahan:', xhr.responseText);
                                            // Misalnya, Anda dapat menampilkan pesan kesalahan kepada pengguna
                                        }
                                    });
                                    }

                                    function editSoalSubCpmk(id){
                                    $.ajax({
                                        url: "{{ url('admin/rps/editsoalsubcpmk') }}/" + id,
                                        type: 'GET',
                                        success: function(response){
                                            $('#pilih_subcpmk').val(response.data.subcpmk_id);
                                            $('#bentuk_soal').val(response.data.kode_subcpmk);
                                            $('#bobot').val(response.data.bobot_soal);
                                            $('#waktu_pelaksanaan').val(response.data.waktu_pelaksanaan);
                                            // var form = document.getElementById('myFormCpmk');
                                            // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';

                                            // form.append(hiddenInputId);
                                            var form = document.getElementById('myFormSubCpmk');
                                            var hiddenInputId = document.createElement('input');
                                            hiddenInputId.type = 'hidden';
                                            hiddenInputId.name = 'subcpmk_id';
                                            hiddenInputId.value = response.data.id;

                                            form.appendChild(hiddenInputId);

                                        },
                                        error: function(xhr){
                                            console.log(xhr.responseText);
                                        }
                                    });
                                    document.getElementById('tambah-soalsubcpmk').style.display = 'none';
                                    document.getElementById('simpan-soalsubcpmk-edit').style.display = 'block';
                                    };

                                    function saveEditedSoalSubCpmk() {
                                    // Mendapatkan nilai input dari form atau elemen lainnya
                                    var form = $('#myFormSoal');

                                    // Melakukan permintaan AJAX untuk menyimpan data yang diedit
                                    $.ajax({
                                        url: "{{ url('admin/rps/updatesoalsubcpmk') }}", // URL untuk menyimpan data yang diedit
                                        type: 'PUT', // Metode HTTP untuk menyimpan data
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                        contentType: 'application/json', // Tipe konten yang dikirimkan dalam permintaan
                                        data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
                                        success: function(response){
                                            // Handle success response
                                            console.log('Data berhasil diperbarui:', response);
                                            // Misalnya, Anda dapat menampilkan pesan sukses kepada pengguna
                                        },
                                        error: function(xhr){
                                            // Handle error response
                                            console.log('Terjadi kesalahan:', xhr.responseText);
                                            // Misalnya, Anda dapat menampilkan pesan kesalahan kepada pengguna
                                        }
                                    });
                                    }
                        </script>
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@section('script')
<script>

</script>

@endsection
