@extends('layouts.dosen.main')

@section('content')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Data RPS {{ $rps->nama_matkul." (". $rps->tahun_rps .")" }}</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dosen.matakuliah') }}">Data RPS</a></li>
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
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1"  aria-expanded="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Data CPMK</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-2">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"  aria-expanded="true">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Data Sub CPMK</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-3">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3"  aria-expanded="true">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">Data Tugas</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="bs-stepper-content">
                                        <div id="test-l-1" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    @foreach ($cpl as $id => $name)
                                                    <div class="col-md-12 mb-3 d-flex">
                                                        <div class="col-md-2 align-self-center">
                                                            <h6>{{ $name }}</h6>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <button class="btn btn-sm btn-primary" type="button" onclick="inputCpl({{ $id }}, '{{ $name }}')"><i class="nav-icon fas fa-plus mr-2"></i> Tambah CPMK</button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-7">
                                                    <form enctype="multipart/form-data" id="formCpmk">
                                                        @csrf
                                                        <div class="sortinput" style="margin-bottom: 1rem">
                                                            <label for="cpl_id">Kode CPL</label>
                                                            <input type="hidden" name="cpl_id" id="hidden-id">
                                                            <input type="text" id="cpl-option" class="form-control" placeholder="Kode CPL" value="" disabled>
                                                            {{-- <select class="form-select w-100 mb-1" style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;" onfocus="this.style.borderColor = '#80bdff';" onblur="this.style.borderColor = '#939ba2';" aria-label="Default select example" id="cpl_id" name="cpl_id">
                                                                <option selected>-- Pilih CPL --</option>
                                                                @foreach ($cpl as $id => $name)
                                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                                @endforeach
                                                            </select> --}}
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kode_cpmk">Kode CPMK</label>
                                                            <input type="text" class="form-control" id="kode_cpmk" name="kode_cpmk" placeholder="Kode CPMK">
                                                        </div>
                                                        <div class="textinput" style="margin-bottom: 1rem">
                                                            <label for="deskripsi">Deskripsi CPMK</label>
                                                            <textarea id="deskripsi_cpmk" name="deskripsi_cpmk" style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required></textarea>
                                                        </div>
                                                        <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="tambah-cpmk" onclick="addCpmk({{ $rps->id }})"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                        </div>
                                                        <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="tabel-cpmk"></div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-2" class="content" role="tabpanel" aria-labelledby="stepper1trigger2">
                                            <div class="row">
                                                <div class="col-md-5" id="input-kodecpmk">

                                                </div>

                                                <div class="col-md-7">
                                                    <form enctype="multipart/form-data" id="formSubCpmk">
                                                        @csrf
                                                        <div class="form-group" style="margin-bottom: 1rem">
                                                            <label for="pilih_cpmk">Kode CPMK</label>
                                                            <input type="hidden" name="pilih_cpmk" id="cpmk-id">
                                                            <input type="text" id="cpmk-option" class="form-control" placeholder="CPMK" value="" disabled>
                                                            {{-- <select class="form-select w-100 mb-1"
                                                                style="height: 38px; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px; transition: 0.3s ease;"
                                                                onfocus="this.style.borderColor = '#80bdff';"
                                                                onblur="this.style.borderColor = '#939ba2';"
                                                                aria-label="CPMK" id="pilih_cpmk" name="pilih_cpmk"> --}}
                                                                {{-- <option>-- CPMK --</option> --}}
                                                                {{-- @foreach ($kode_cpmk as $key => $data) --}}
                                                                    {{-- <option value="" id="cpmk-option" selected>-- CPMK --</option> --}}
                                                                {{-- @endforeach --}}
                                                            {{-- </select> --}}
                                                        </div>
                                                        {{-- <input type="hidden" value="{{ $cpmk->id }}"> --}}
                                                        <div class="form-group">
                                                            <label for="kode_subcpmk">Kode Sub CPMK</label>
                                                            <input type="text" class="form-control" id="kode_subcpmk"
                                                                name="kode_subcpmk" placeholder="Kode Sub CPMK">
                                                        </div>
                                                        <div class="textinput" style="margin-bottom: 1rem">
                                                            <label for="deskripsi">Deskripsi Sub CPMK</label>
                                                            <textarea id="deskripsi_subcpmk" name="deskripsi_subcpmk"
                                                                style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px"
                                                                required></textarea>
                                                        </div>
                                                        {{-- <div class="row justify-content-end"> --}}
                                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                                <button class="btn btn-primary" type="button" id="tambah-subcpmk" onclick="addSubCpmk({{ $rps->id }})">Tambah</button>
                                                            </div>
                                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                                <button class="btn btn-primary" type="button" id="simpan-subcpmk-edit" style="display: none" onclick="saveEditedSubCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                            </div>
                                                        {{-- </div> --}}
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="tabel-subcpmk"></div>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-3" class="content" role="tabpanel" aria-labelledby="stepper1trigger3">
                                            <form enctype="multipart/form-data" id="formSoal">
                                                @csrf
                                                {{-- <div class="sortinput" style="margin-bottom: 1rem">
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
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="pilih_subcpmk">Kode Sub CPMK</label>
                                                    <div class="row" id="input-kodesubcpmk">

                                                    </div>
                                                </div>
                                                <div class="textinput" style="margin-bottom: 1rem">
                                                    <label for="bentuk_soal">Bentuk Soal</label>
                                                    <select class="form-control select2bs4" id="bentuk_soal" name="bentuk_soal" style="resize: none; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required>
                                                        <option selected>-- Pilih Bentuk Soal --</option>
                                                        @foreach ($data_soal as $soalid => $soal)
                                                            <option value="{{ $soal }}">{{ $soal}}</option>
                                                        @endforeach
                                                    </select>
                                                    {{-- <textarea id="bentuk_soal" name="bentuk_soal" style="resize: none; height: 100px; width: 100%; border: 1px solid #ced4da; border-radius: 4px; color: #939ba2; padding: 6px 12px" required></textarea> --}}
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="bobot">Bobot</label>
                                                        <div class="input-group mb-3">
                                                            <input id="bobot" type="number" step="0.01" class="form-control"
                                                                placeholder="Bobot" aria-label="Bobot"
                                                                aria-describedby="basic-addon2" name="bobot">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-5">
                                                        <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label><br>
                                                        {{-- <div id="slider"></div> --}}
                                                        <div id="sliderContainer">
                                                            <input id="waktu_pelaksanaan" type="text" class="slider"  />
                                                        </div>
                                                        <input id="waktu_pelaksanaan_edit" type="text" class="slider" style="display: none"/>
                                                        <p>Minggu
                                                            <span class="range-value" id="rangeValue1">1</span> -
                                                            <span class="range-value" id="rangeValue2">16</span>
                                                        </p>
                                                        <input type="hidden" id="waktu_pelaksanaan_start" name="waktu_pelaksanaan_start">
                                                        <input type="hidden" id="waktu_pelaksanaan_end" name="waktu_pelaksanaan_end">
                                                    </div>
                                                    {{-- <div class="col-lg-8">
                                                        <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                                                        <div class="input-group mb-3">
                                                            <input id="waktu_pelaksanaan" type="text" class="form-control"
                                                                aria-describedby="basic-addon2" name="waktu_pelaksanaan" required>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="button" id="tambah-soalsubcpmk" onclick="addSoal({{ $rps->id }})"><i class="nav-icon fas fa-plus mr-2"></i>Tambah Data</button>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                    <button class="btn btn-primary" type="button" id="simpan-soalsubcpmk-edit" style="display: none" onclick="saveEditedSoalSubCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                </div>
                                            </form>
                                            <div id="tabel-tugas"></div>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="simpan()">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <script src="dist/js/bs-stepper.js"></script> --}}
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper1 = new Stepper(document.querySelector('#stepper1'), {
            linear: false,
            animation: true
        });

        getListSubCpmk();
        getListCpmk();
        getListTugas();

        listInputCpmk();
        listInputSubCpmk();
    });


    document.addEventListener('DOMContentLoaded', function () {
    //content goes here
    });

    function initializeSlider(startValue, endValue) {
        var slider = new Slider("#waktu_pelaksanaan", {
            min: 1,
            max: 16,
            range: true,
            value: [startValue, endValue],
            tooltip_split: true
        });

        slider.on("slide", function(slideEvt) {
            $("#rangeValue1").text(slideEvt[0]);
            $("#rangeValue2").text(slideEvt[1]);
            $("#waktu_pelaksanaan_start").val(slideEvt[0]);
            $("#waktu_pelaksanaan_end").val(slideEvt[1]);
        });
    }
    $(document).ready(function() {
        initializeSlider(1, 16);
        // slider.setValue()
    });
    function inputCpl(id, kode) {
        var hiddenElement = document.getElementById('hidden-id');
        var optionElement = document.getElementById('cpl-option');
        hiddenElement.value = id;
        optionElement.value = kode;
    }
    function addCpmk(id) {
        var form = $('#formCpmk');
        $.ajax({
            type: 'POST',
            url: "{{ url('dosen/rps/create/cpmk') }}/" + id,
            data: form.serialize(),
            success: function(response) {
                if (response.status == "success") {
                    Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                }).then((result) => {
                    // Check if the user clicked "OK"
                    if (result.isConfirmed) {
                        // Redirect to the desired URL
                        form[0].reset();
                        getListCpmk();
                        listInputCpmk();
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
                        // window.location.reload();
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
                        // window.location.reload();
                    };
                });
                }
                // Handle error here
                console.error(xhr.responseText);
            }
        });
    }
    function inputCpmk(id, kode) {
        var hiddenElement = document.getElementById('cpmk-id');
        var optionElement = document.getElementById('cpmk-option');
        hiddenElement.value = id;
        optionElement.value = kode;
    }
    function addSubCpmk(id) {
        var form = $('#formSubCpmk');
        $.ajax({
            type: 'POST',
            url: "{{ url('dosen/rps/create/subcpmk') }}/" + id,
            data: form.serialize(),
            success: function(response) {
                if (response.status == "success") {
                    Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                }).then((result) => {
                    // Check if the user clicked "OK"
                    if (result.isConfirmed) {
                        // Redirect to the desired URL
                        form[0].reset();
                        getListSubCpmk();
                        listInputSubCpmk();
                        // window.location.href = "{{ route('admin.rps.create', '') }}/" + id;
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
                        form[0].reset();
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
                });
                }
                // Handle error here
                console.error(xhr.responseText);
            }
        });
    }
    function addSoal(id) {
        var form = $('#formSoal');
        $.ajax({
            type: 'POST',
            url: "{{ url('dosen/rps/create/soal') }}/" + id,
            data: form.serialize(),
            success: function(response) {
                if (response.status == "success") {
                    Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                }).then((result) => {
                    // Check if the user clicked "OK"
                    if (result.isConfirmed) {
                        // Redirect to the desired URL
                        form[0].reset();
                        getListTugas();
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
                        // window.location.reload();
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
                        // window.location.reload();
                    };
                });
                }
                // Handle error here
                console.error(xhr.responseText);
            }
        });
    }
        function deleteCpmk(id){
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
                        url: "{{ url('dosen/rps/deletecpmk') }}/" + id,
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
                                        getListCpmk();
                                        getListSubCpmk();
                                        getListTugas();
                                        // window.location.reload();
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
                        url: "{{ url('dosen/rps/deletecpmk/sub') }}/" + id,
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
                                        // window.location.reload();
                                        getListSubCpmk();
                                        getListTugas();
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
                        url: "{{ url('dosen/rps/deletecpmk/sub/soal') }}/" + id,
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
                                        // Perbarui langkah saat ini setelah berhasil menghapus data
                                        getListTugas();
                                        // window.location.reload();
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
                // var stepper1 = new Stepper(document.querySelector('#stepper1'));
                stepper1.to(langkah);
            }


            function editCpmk(id){
                $.ajax({
                    url: "{{ url('dosen/rps/editcpmk') }}/" + id,
                    type: 'GET',
                    success: function(response){
                        $('#hidden-id').val(response.data.cpl_id);
                        $('#cpl-option').val(response.data.kode_cpl);
                        $('#kode_cpmk').val(response.data.kode_cpmk);
                        $('#deskripsi_cpmk').val(response.data.deskripsi);
                        // var form = document.getElementById('myFormCpmk');
                        // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';

                        // form.append(hiddenInputId);
                        var form = document.getElementById('formCpmk');
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
                var form = $('#formCpmk');
                Swal.fire({
                title: "Konfirmasi Edit",
                text: "Apakah anda yakin ingin mengedit data ini?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, edit"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('dosen/rps/updatecpmk') }}", // URL untuk menyimpan data yang diedit
                            type: 'PUT', // Metode HTTP untuk menyimpan data
                            headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            contentType: 'application/x-www-form-urlencoded', // Tipe konten yang dikirimkan dalam permintaan
                            data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
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
                                            form[0].reset();
                                            getListCpmk();

                                            document.getElementById('tambah-cpmk').style.display = 'block';
                                            document.getElementById('simpan-cpmk-edit').style.display = 'none';
                                        };
                                            // window.location.href = "{{ route('admin.kelas') }}";
                                    });
                                }
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
                                        // window.location.reload();
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
                                        // window.location.reload();
                                    };
                                });
                                }
                                // Handle error here
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }

            function editSubCpmk(id){
                $.ajax({
                    url: "{{ url('dosen/rps/editsubcpmk') }}/" + id,
                    type: 'GET',
                    success: function(response){
                        $('#cpmk-id').val(response.data.cpmk_id);
                        $('#cpmk-option').val(response.data.kode_cpmk);
                        $('#kode_subcpmk').val(response.data.kode_subcpmk);
                        $('#deskripsi_subcpmk').val(response.data.deskripsi);
                        // var form = document.getElementById('myFormCpmk');
                        // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';

                        // form.append(hiddenInputId);
                        var form = document.getElementById('formSubCpmk');
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
                var form = $('#formSubCpmk');

                Swal.fire({
                title: "Konfirmasi Edit",
                text: "Apakah anda yakin ingin mengedit data ini?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, edit"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Melakukan permintaan AJAX untuk menyimpan data yang diedit
                        $.ajax({
                            url: "{{ url('dosen/rps/updatesubcpmk') }}", // URL untuk menyimpan data yang diedit
                            type: 'PUT', // Metode HTTP untuk menyimpan data
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            contentType: 'application/x-www-form-urlencoded', // Tipe konten yang dikirimkan dalam permintaan
                            data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
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
                                            form[0].reset();
                                            getListSubCpmk();

                                            document.getElementById('tambah-subcpmk').style.display = 'block';
                                            document.getElementById('simpan-subcpmk-edit').style.display = 'none';
                                        };
                                            // window.location.href = "{{ route('admin.kelas') }}";
                                    });
                                }
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
                                        // window.location.reload();
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
                                        // window.location.reload();
                                    };
                                });
                                }
                                // Handle error here
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }

            function editSoalSubCpmk(id){
                document.getElementById('waktu_pelaksanaan').style.display = 'none';
                document.getElementById('waktu_pelaksanaan_edit').style.display = 'block';
            $.ajax({
                url: "{{ url('dosen/rps/editsoalsubcpmk') }}/" + id,
                type: 'GET',
                success: function(response){
                    // $('#pilih_subcpmk').val(response.data.subcpmk_id);
                    document.querySelectorAll('input[name="pilih_subcpmk[]"]').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });

                    // Check the relevant checkboxes
                    let subcpmkId = response.data.subcpmk_id;
                    document.getElementById('subcpmk_' + subcpmkId).checked = true;

                    $('#bentuk_soal').val(response.data.bentuk_soal).change();
                    $('#bobot').val(response.data.bobot_soal);
                    // $('#waktu_pelaksanaan').val(response.data.waktu_pelaksanaan);
                    // var form = document.getElementById('myFormCpmk');
                    // var hiddenInputId = '<input type="hidden" name="cpmk_id" value="' + response.data.id+ '">';
                    // $("#waktu_pelaksanaan").hide();
                    var sliderContainer = document.getElementById('sliderContainer');
                    if (sliderContainer.style.display === 'none') {
                        sliderContainer.style.display = 'block';
                    } else {
                        sliderContainer.style.display = 'none';
                    }

                    var form = document.getElementById('formSoal');
                    // var sliderInput = document.createElement('input');
                    // sliderInput.setAttribute('id', 'waktu_pelaksanaan_edit_' + response.data.id );
                    // sliderInput.setAttribute('type', 'text');
                    // sliderInput.classList.add('slider');
                    // sliderInput.style.display = 'none';
                    // form.appendChild(sliderInput);

                    var startValue = parseInt(response.minggu_mulai);
                    var endValue = parseInt(response.minggu_akhir);

                    // initializeSlider(startValue, endValue);
                    // initializeSlider(startValue,endValue);
                    var slider = new Slider("#waktu_pelaksanaan_edit", {
                        min: 1,
                        max: 16,
                        range: true,
                        value: [startValue, endValue],
                        tooltip_split: true
                    });

                    slider.on("slide", function(slideEvt) {
                        $("#rangeValue1").text(slideEvt[0]);
                        $("#rangeValue2").text(slideEvt[1]);
                        $("#waktu_pelaksanaan_start").val(slideEvt[0]);
                        $("#waktu_pelaksanaan_end").val(slideEvt[1]);
                    });

                    // // Atur nilai input terkait
                    $("#rangeValue1").text(startValue);
                    $("#rangeValue2").text(endValue);
                    $("#waktu_pelaksanaan_start").val(startValue);
                    $("#waktu_pelaksanaan_end").val(endValue);
                    // // form.append(hiddenInputId);

                    var hiddenInputId = document.createElement('input');
                    hiddenInputId.type = 'hidden';
                    hiddenInputId.name = 'soal_subcpmk_id';
                    hiddenInputId.value = response.data.id;

                    // <input id="waktu_pelaksanaan_edit" type="text" class="slider" style="display: none"/>

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
            var form = $('#formSoal');
                console.log(form);
            Swal.fire({
            title: "Konfirmasi Edit",
            text: "Apakah anda yakin ingin mengedit data ini?",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, edit"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Melakukan permintaan AJAX untuk menyimpan data yang diedit
                    $.ajax({
                        url: "{{ url('dosen/rps/updatesoalsubcpmk') }}", // URL untuk menyimpan data yang diedit
                        type: 'PUT', // Metode HTTP untuk menyimpan data
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        contentType: 'application/x-www-form-urlencoded',  // Tipe konten yang dikirimkan dalam permintaan
                        data: form.serialize(), // Mengonversi objek JavaScript menjadi JSON
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
                                        form[0].reset();
                                        getListTugas();

                                        document.getElementById('tambah-soalsubcpmk').style.display = 'block';
                                        document.getElementById('simpan-soalsubcpmk-edit').style.display = 'none';
                                    };
                                        // window.location.href = "{{ route('admin.kelas') }}";
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status == 422) {
                                var errorMessage = xhr.responseJSON.message;
                                Swal.fire({
                                icon: "error",
                                title:"Validation Error",
                                text: errorMessage,
                            }).then((result) => {

                            });
                            }
                            else{
                                var errorMessage = xhr.responseJSON.message;
                                Swal.fire({
                                icon: "error",
                                title:"Error!",
                                text: errorMessage,
                            }).then((result) => {

                            });
                            }
                            // Handle error here
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            }

            function simpan(){
                Swal.fire({
                    title: "Are you sure?",
                    // text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, simpan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Sukses!",
                            text: "Data Berhasil Disimpan.",
                            icon: "success"
                        }).then((result) => {
                        // Check if the user clicked "OK"
                            if (result.isConfirmed) {
                                // Redirect to the desired URL
                                window.location.href = "{{ route('dosen.matakuliah') }}";
                            };
                            // window.location.href = "{{ route('admin.kelas') }}";
                        });
                    }
                });
            }

            function getListSubCpmk(page = null){
                $.ajax({
                        url: "{{ url('dosen/rps/listsubcpmk') }}/" + {{ $rps->id }}, // URL untuk menyimpan data yang diedit
                        type: 'GET', // Metode HTTP untuk menyimpan data
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        data: {
                            page: page
                        },
                        success: function(data) {
                            // if (response.status === 'success') {
                                console.log(data);
                                $('#tabel-subcpmk').html(data);
                            // }
                        },
                        error: function(xhr, status, error) {
                            // Handle error here
                            console.error(xhr.responseText);
                        }
                    });
            }

        $(document).on('click', '#tabel-data .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getListSubCpmk(page);
        });

            function getListCpmk(page = null){
                $.ajax({
                    url: "{{ url('dosen/rps/listcpmk') }}/" + {{ $rps->id }}, // URL untuk menyimpan data yang diedit
                    type: 'GET', // Metode HTTP untuk menyimpan data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        page: page
                    },
                    success: function(data) {
                    // if (response.status === 'success') {
                        console.log(data);
                        $('#tabel-cpmk').html(data);
                    // }
                    },
                    error: function(xhr, status, error) {
                    // Handle error here
                        console.error(xhr.responseText);
                    }
                });
            }

        $(document).on('click', '#tabel-data-cpmk .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getListCpmk(page);
        });

        function getListTugas(page = null){
                $.ajax({
                    url: "{{ url('dosen/rps/listtugas') }}/" + {{ $rps->id }}, // URL untuk menyimpan data yang diedit
                    type: 'GET', // Metode HTTP untuk menyimpan data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        page: page
                    },
                    success: function(data) {
                    // if (response.status === 'success') {
                        console.log(data);
                        $('#tabel-tugas').html(data);
                    // }
                    },
                    error: function(xhr, status, error) {
                    // Handle error here
                        console.error(xhr.responseText);
                    }
                });
            }

        $(document).on('click', '#tabel-data-tugas .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getListTugas(page);
        });

        function listInputCpmk() {
            $.ajax({
                    url: "{{ url('dosen/rps/listcpmk/input') }}/" + {{ $rps->id }}, // URL untuk menyimpan data yang diedit
                    type: 'GET', // Metode HTTP untuk menyimpan data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                    // if (response.status === 'success') {
                        console.log(data);
                        $('#input-kodecpmk').html(data);
                    // }
                    },
                    error: function(xhr, status, error) {
                    // Handle error here
                        console.error(xhr.responseText);
                    }
                });
        }

        function listInputSubCpmk() {
            $.ajax({
                    url: "{{ url('dosen/rps/listsubcpmk/input') }}/" + {{ $rps->id }}, // URL untuk menyimpan data yang diedit
                    type: 'GET', // Metode HTTP untuk menyimpan data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                    // if (response.status === 'success') {
                        console.log(data);
                        $('#input-kodesubcpmk').html(data);
                    // }
                    },
                    error: function(xhr, status, error) {
                    // Handle error here
                        console.error(xhr.responseText);
                    }
                });
        }
</script>
@endsection
