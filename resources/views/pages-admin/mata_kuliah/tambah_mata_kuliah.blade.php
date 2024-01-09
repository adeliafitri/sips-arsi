@extends('layouts.admin.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Mata Kuliah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.matakuliah') }}">Data Mata Kuliah</a></li>
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
                            <h3 class="card-title col align-self-center">Form Tambah Data Mata Kuliah</h3>
                            <!-- <div class="col-sm-2">
                            <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                            </div> -->
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
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-4">
                                            <button type="button" class="btn step-trigger">
                                                <span class="bs-stepper-circle">4</span>
                                                <span class="bs-stepper-label">Fourth step</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <div id="test-l-1" class="content">
                                            <form action="{{ route('admin.matakuliah.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @CSRF
                                                <div class="form-group">
                                                    <label for="kode_matkul">Kode Matkul</label>
                                                    <input type="text" class="form-control" id="kode_matkul"
                                                        name="kode_matkul" placeholder="Kode Mata Kuliah">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_matkul">Nama Matkul</label>
                                                    <input type="text" class="form-control" id="nama_matkul"
                                                        name="nama_matkul" placeholder="Nama Mata Kuliah">
                                                </div>
                                                <div class="form-group">
                                                    <label for="sks">SKS</label>
                                                    <input type="number" class="form-control" id="sks" name="sks"
                                                        placeholder="SKS">
                                                </div>
                                            </form>
                                            <a href="{{ route('admin.matakuliah') }}" class="btn btn-default">Cancel</a>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-2" class="content">
                                            <form action="{{ route('admin.matakuliah.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @CSRF
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_cpl">Pilih CPL</label>
                                                    <select class="form-select w-100 mb-1"
                                                        style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                        onfocus="this.style.borderColor = '#80bdff';"
                                                        onblur="this.style.borderColor = '#939ba2';"
                                                        aria-label="Default select example">
                                                        <option selected>Pilih CPL</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_cpmk">Kode CPMK</label>
                                                    <input type="text" class="form-control" id="kode_cpmk"
                                                        name="kode_cpmk" placeholder="Kode CPMK">
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi" name="deskripsi"
                                                        style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px"
                                                        required></textarea>
                                                </div>
                                            </form>
                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('')
                                                    <button class="btn btn-primary" type="submit"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </form>
                                            </div>
                                            <table class="table table-bordered">
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
                                                    {{-- @foreach ($data as $key => $datas) --}}
                                                        <tr>
                                                            <td>1</td>
                                                            <td>CPL1</td>
                                                            <td>CPMK1</td>
                                                            <td>Deskripsi 1</td>
                                                            <td class="d-flex justify-content-center">
                                                                <form
                                                                    action=""
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-danger ml-1" type="submit"><i
                                                                            class="nav-icon fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    {{-- @endforeach --}}
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-3" class="content">
                                            <form action="{{ route('admin.matakuliah.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @CSRF
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_cpl">Pilih CPMK</label>
                                                    <select class="form-select w-100 mb-1"
                                                        style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                        onfocus="this.style.borderColor = '#80bdff';"
                                                        onblur="this.style.borderColor = '#939ba2';"
                                                        aria-label="Default select example">
                                                        <option selected>Pilih CPMK</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_cpmk">Kode Sub CPMK</label>
                                                    <input type="text" class="form-control" id="kode_cpmk"
                                                        name="kode_cpmk" placeholder="Kode CPMK">
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi" name="deskripsi"
                                                        style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px"
                                                        required></textarea>
                                                </div>
                                            </form>
                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('')
                                                    <button class="btn btn-primary" type="submit"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </form>
                                            </div>
                                            <table class="table table-bordered">
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
                                                    {{-- @foreach ($data as $key => $datas) --}}
                                                        <tr>
                                                            <td>1</td>
                                                            <td>CPL1</td>
                                                            <td>CPMK1</td>
                                                            <td>Deskripsi 1</td>
                                                            <td class="d-flex justify-content-center">
                                                                <form
                                                                    action=""
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-danger ml-1" type="submit"><i
                                                                            class="nav-icon fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    {{-- @endforeach --}}
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-4" class="content">
                                            <form action="{{ route('admin.matakuliah.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @CSRF
                                                <div class="sortinput" style="margin-bottom: 1rem">
                                                    <label for="pilih_cpl">Pilih Sub CPMK</label>
                                                    <select class="form-select w-100 mb-1"
                                                        style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                        onfocus="this.style.borderColor = '#80bdff';"
                                                        onblur="this.style.borderColor = '#939ba2';"
                                                        aria-label="Default select example">
                                                        <option selected>Pilih Sub CPMK</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="bentuk_soal">Bentuk Soal</label>
                                                    <textarea id="bentuk_soal" name="bentuk_soal"
                                                        style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px"
                                                        required></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="bobot">Bobot</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" placeholder="Bobot" aria-label="Bobot" aria-describedby="basic-addon2">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2" required>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('')
                                                    <button class="btn btn-primary" type="submit"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </form>
                                            </div>
                                            <table class="table table-bordered">
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
                                                    {{-- @foreach ($data as $key => $datas) --}}
                                                        <tr>
                                                            <td>1</td>
                                                            <td>CPL1</td>
                                                            <td>CPMK1</td>
                                                            <td>Deskripsi 1</td>
                                                            <td class="d-flex justify-content-center">
                                                                <form
                                                                    action=""
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-danger ml-1" type="submit"><i
                                                                            class="nav-icon fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    {{-- @endforeach --}}
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

                            stepper1Node.addEventListener('show.bs-stepper', function(event) {
                                console.warn('show.bs-stepper', event);
                            });
                            stepper1Node.addEventListener('shown.bs-stepper', function(event) {
                                console.warn('shown.bs-stepper', event);
                            });
                        </script>

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
