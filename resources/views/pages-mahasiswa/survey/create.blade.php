@extends('layouts.mahasiswa.main')

@section('content')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Form Kuisioner</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dosen.matakuliah') }}">Data RPS</a></li> --}}
                        <li class="breadcrumb-item active">Form Kuisioner</li>
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
                            <h3 class="card-title col align-self-center">Form Kuisioner</h3>
                            {{-- <div class="">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="nav-icon fas fa-file-excel mr-2"></i> Excel
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('dosen.rps.download-excel', $rps->id) }}"><i class="fas fa-download mr-2"></i> Export Excel</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#importExcelModal"><i class="fas fa-upload mr-2"></i> Import Excel</a>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- modal import --}}
                            {{-- <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importExcelModalLabel">Import Excel</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
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
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div id="stepper1" class="bs-stepper">
                                    <div class="bs-stepper-header">
                                        <div class="step" data-target="#test-l-1">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1"  aria-expanded="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Kepuasan Mahasiswa</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-2">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"  aria-expanded="true">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Kinerja Dosen</span>
                                            </button>
                                        </div>
                                        {{-- <div class="line"></div> --}}
                                        {{-- <div class="step" data-target="#test-l-3">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3"  aria-expanded="true">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">Data Tugas</span>
                                            </button>
                                        </div> --}}
                                    </div>

                                    <div class="bs-stepper-content">
                                        <div id="test-l-1" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
                                            <div class="row">
                                                {{-- <div class="col-md-5">
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
                                                </div> --}}
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formKepuasan">
                                                        @CSRF
                                                        <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_kepuasan }}">

                                                        @foreach ($kepuasanQuestions as $index => $question)
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_kepuasan[{{ $question->id }}]" value="{{ $key }}" required>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_kepuasan"><strong>Saran</strong></label>
                                                            <textarea name="saran_kepuasan" class="form-control" rows="3"></textarea>
                                                        </div>

                                                        <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="tambah-cpmk" onclick="addKepuasan()">Kirim Kuisioner</button>
                                                        </div>
                                                        {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                        </div> --}}
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="tabel-cpmk"></div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-2" class="content" role="tabpanel" aria-labelledby="stepper1trigger2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formKinerja">
                                                        @csrf
                                                        <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_kinerja }}">

                                                        @foreach ($kinerjaQuestions as $index => $question)
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_kinerja[{{ $question->id }}]" value="{{ $key }}" required>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="form-group mt-3">
                                                            <label>Saran untuk Dosen</label>
                                                            <textarea name="saran_kinerja" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                        {{-- <div class="row justify-content-end"> --}}
                                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                                <button class="btn btn-primary" type="button" id="tambah-subcpmk" onclick="addKinerja()">Kirim Kuisioner</button>
                                                            </div>
                                                        {{-- </div> --}}
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="tabel-subcpmk"></div>
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

    function addKepuasan() {
        var form = $('#formKepuasan');
        $.ajax({
            type: 'POST',
            url: "{{ url('mahasiswa/survey/kepuasan-mahasiswa') }}/",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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
                        form.find('input, textarea, button').prop('disabled', true);
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

    function addKinerja() {
        var form = $('#formKinerja');
        $.ajax({
            type: 'POST',
            url: "{{ url('mahasiswa/survey/kinerja-dosen') }}/",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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
                        form.find('input, textarea, button').prop('disabled', true);
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
                                window.location.href = "{{ route('mahasiswa.kelaskuliah') }}";
                            };
                            // window.location.href = "{{ route('admin.kelas') }}";
                        });
                    }
                });
            }

        function toggleInput() {
            const select = document.getElementById("jenis_tugas_select");
            const input = document.getElementById("jenis_tugas_input");

            if (select.value === "lainnya") {
                input.style.display = "block";
                input.value = ''; // kosongkan jika sebelumnya ada
            } else {
                input.style.display = "none";
                input.value = select.value; // supaya tetap dikirim via 'jenis_tugas'
            }
        }

        // Jika halaman reload karena validasi gagal, tetap tampilkan input manual jika sebelumnya pilih "lainnya"
        document.addEventListener('DOMContentLoaded', function() {
            toggleInput();
        });
</script>
@endsection
