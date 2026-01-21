@extends('layouts.mahasiswa.main')

@section('content')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Penilaian Kinerja Pembimbingan Tugas Akhir</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dosen.matakuliah') }}">Data RPS</a></li> --}}
                        <li class="breadcrumb-item active">Penilaian Kinerja Pembimbingan Tugas Akhir</li>
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
                            <h3 class="card-title col align-self-center">Penilaian Kinerja Pembimbingan Tugas Akhir Tahun Ajaran {{ $tahunAkademik }} {{ $semester }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div id="stepper1" class="bs-stepper">
                                    <div class="bs-stepper-header">
                                        <div class="step" data-target="#test-l-1">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1"  aria-expanded="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Dosen Pembimbing 1</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-2">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"  aria-expanded="true">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Dosen Pembimbing 2</span>
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
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formPembimbingan" method="POST" action="{{ route('mahasiswa.kuisioner.storePembimbingan') }}">
                                                        @CSRF
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_pembimbingan }}">

                                                        <div class="form-group">
                                                            <label for="dosen_pembimbing1_id">Dosen Pembimbing 1</label>
                                                            <select class="form-control select2bs4" id="dosen_pembimbing1_id" name="dosen_pembimbing1_id" {{ $dospem1_isFilled ? 'disabled' : '' }}>
                                                                <option value="">- Pilih Dosen -</option>
                                                                @foreach ($dosen as $id => $name)
                                                                    <option value="{{ $id }}" {{ $dospem1_dosen_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @foreach ($pembimbinganQuestions as $index => $question)
                                                            @php
                                                                $answer = $dospem1_answers->get($question->id);
                                                                $skor_jawaban = $answer ? $answer->skor_jawaban : null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_pembimbingan[{{ $question->id }}]" value="{{ $key }}" required {{ $skor_jawaban == $key ? 'checked' : '' }} {{ $dospem1_isFilled ? 'disabled' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="form-group mt-3">
                                                            <label>Pelaksanaan Seminar Proposal</label>
                                                            @if ($dospem1_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">{{ $dospem1_tanggal_sempro ?? 'N/A' }}</p>
                                                            @else
                                                                <input type="date" name="pelaksanaan_seminar" class="form-control" required>
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Pelaksanaan Sidang</label>
                                                            @if ($dospem1_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">{{ $dospem1_tanggal_sidang ?? 'N/A' }}</p>
                                                            @else
                                                                <input type="date" name="pelaksanaan_sidang" class="form-control" required>
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Kendala Skripsi</label><br>
                                                            @if ($dospem1_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">
                                                                    {{ $dospem1_kendala_skripsi ?: 'Tidak ada kendala yang dipilih.' }}
                                                                </p>
                                                            @else
                                                                @foreach (['komunikasi','sarana prasarana','keuangan','motivasi','tidak ada kendala','lainnya'] as $option)
                                                                    <label class="text-capitalize">
                                                                        <input type="checkbox" name="kendala[]" value="{{ $option }}"
                                                                            {{ in_array($option, old('kendala', [])) ? 'checked' : '' }}>
                                                                        {{ $option }}
                                                                    </label><br>
                                                                @endforeach
                                                            @endif
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="saran_pembimbingan"><strong>Saran</strong></label>
                                                            <textarea name="saran_pembimbingan" class="form-control" rows="3" {{ $dospem1_isFilled ? 'disabled' : '' }}>{{ $dospem1_suggestion }}</textarea>
                                                        </div>

                                                        <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="submit" id="tambah-cpmk" {{ $dospem1_isFilled ? 'disabled' : '' }}>Kirim Kuisioner</button>
                                                            {{-- <button class="btn btn-primary" type="button" id="tambah-cpmk" onclick="addPembimbingan()" {{ $dospem1_isFilled ? 'disabled' : '' }}>Kirim Kuisioner</button> --}}
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
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formPembimbingan2" method="POST"
    action="{{ route('mahasiswa.kuisioner.storePembimbingan2') }}">
                                                        @csrf
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}"> --}}
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_pembimbingan }}">

                                                        <div class="form-group">
                                                            <label for="dosen_pembimbing2_id">Dosen Pembimbing 2</label><br>
                                                            <select class="form-control select2bs4" id="dosen_pembimbing2_id" name="dosen_pembimbing2_id" {{ $dospem2_isFilled ? 'disabled' : '' }}>
                                                                <option value="">- Pilih Dosen -</option>
                                                                @foreach ($dosen as $id => $name)
                                                                    <option value="{{ $id }}" {{ $dospem1_dosen_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @foreach ($pembimbinganQuestions as $index => $question)
                                                            @php
                                                                $answer = $dospem2_answers->get($question->id);
                                                                $skor_jawaban = $answer ? $answer->skor_jawaban : null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_pembimbingan2[{{ $question->id }}]" value="{{ $key }}" required {{ $skor_jawaban == $key ? 'checked' : '' }} {{ $dospem2_isFilled ? 'disabled' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="form-group mt-3">
                                                            <label>Pelaksanaan Seminar Proposal</label>
                                                            @if ($dospem2_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">{{ $dospem2_tanggal_sempro ?? 'N/A' }}</p>
                                                            @else
                                                                <input type="date" name="pelaksanaan_seminar2" class="form-control" required>
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Pelaksanaan Sidang</label>
                                                            @if ($dospem1_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">{{ $dospem2_tanggal_sidang ?? 'N/A' }}</p>
                                                            @else
                                                                <input type="date" name="pelaksanaan_sidang2" class="form-control" required>
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Kendala Skripsi</label><br>
                                                            @if ($dospem2_isFilled)
                                                                <p class="form-control-static p-2 border rounded bg-light">
                                                                    {{ $dospem2_kendala_skripsi ?: 'Tidak ada kendala yang dipilih.' }}
                                                                </p>
                                                            @else
                                                                @foreach (['komunikasi','sarana prasarana','keuangan','motivasi','tidak ada kendala','lainnya'] as $option)
                                                                    <label class="text-capitalize">
                                                                        <input type="checkbox" name="kendala2[]" value="{{ $option }}"
                                                                            {{ in_array($option, old('kendala2', [])) ? 'checked' : '' }}>
                                                                        {{ $option }}
                                                                    </label><br>
                                                                @endforeach
                                                            @endif
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Saran</label>
                                                            <textarea name="saran_pembimbingan2" class="form-control" rows="3" required {{ $dospem2_isFilled ? 'disabled' : '' }}>{{ $dospem2_suggestion }}</textarea>
                                                        </div>
                                                        {{-- <div class="row justify-content-end"> --}}
                                                            <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                                <button class="btn btn-primary" type="submit" id="tambah-subcpmk" {{ $dospem2_isFilled ? 'disabled' : '' }}>Kirim Kuisioner</button>
                                                                {{-- <button class="btn btn-primary" type="button" id="tambah-subcpmk" onclick="addPembimbingan2()" {{ $dospem2_isFilled ? 'disabled' : '' }}>Kirim Kuisioner</button> --}}
                                                            </div>
                                                        {{-- </div> --}}
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="tabel-subcpmk"></div>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="simpan()" {{ $dospem1_isFilled && $dospem2_isFilled ? 'disabled' : '' }}>Simpan</button>
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

    $('#formPembimbingan').on('submit', function (e) {
        e.preventDefault();
        submitAjax($(this));
    });

    $('#formPembimbingan2').on('submit', function (e) {
        e.preventDefault();
        submitAjax($(this));
    });

    function submitAjax(form) {
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
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
                                window.location.href = "{{ route('mahasiswa.dashboard') }}";
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
