@extends('layouts.mahasiswa.main')

@section('content')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Form Kuisioner Sarpras, Tendik, Manajemen Prodi, dan Visi Misi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dosen.matakuliah') }}">Data RPS</a></li> --}}
                        <li class="breadcrumb-item active">Form Kuisioner Sarpras, Tendik, Manajemen Prodi, dan Visi Misi</li>
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
                        <div class="col-12 mt-2 justify-content-center">
                            @if($sudahIsi)
                                <div class="alert alert-info">
                                    Anda sudah mengisi kuisioner ini pada tahun {{ $tahunSekarang }}. Anda bisa mengisi lagi tahun {{ $tahunSekarang + 1 }}
                                </div>
                            @endif
                        </div>
                        <div class="card-header d-flex justify-content-end">
                            <h3 class="card-title col align-self-center">Form Kuisioner  Tendik, Manajemen Prodi, dan Visi Misi</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div id="stepper1" class="bs-stepper">
                                    <div class="bs-stepper-header">
                                        <div class="step" data-target="#test-l-1">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1"  aria-expanded="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label"><small>Kinerja Laboran</small></span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-2">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"  aria-expanded="true">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label"><small>Kinerja Staf Administrasi</small></span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-3">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3"  aria-expanded="true">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label"><small>Manajemen Program Studi</small></span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-4">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-3"  aria-expanded="true">
                                                <span class="bs-stepper-circle">4</span>
                                                <span class="bs-stepper-label"><small>Visi Misi, Roadmap Penelitian Pengabdian</small></span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#test-l-5">
                                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger5" aria-controls="test-l-3"  aria-expanded="true">
                                                <span class="bs-stepper-circle">5</span>
                                                <span class="bs-stepper-label"><small>Sarana dan Prasarana</small></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="bs-stepper-content">
                                        <div id="test-l-1" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formSarprasTendikProdi" method="POST"
    action="{{ route('mahasiswa.kuisioner.storeSarprasTendikProdi') }}">
                                                        @CSRF
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}"> --}}
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_sarpras }}">
                                                        {{-- <dd>{{ $id_form_sarpras }}</dd> --}}

                                                        <div class="form-group">
                                                            <label for="nama_laboran">Nama Laboran</label>
                                                            <select class="form-control select2bs4" name="nama_laboran" id="nama_laboran" {{ $disable ? 'disabled' : '' }}>
                                                                @foreach ($laboran as $namaLaboran)
                                                                    <option value="{{ $namaLaboran }}" {{ $nama_laboran == $namaLaboran ? 'selected' : '' }}>{{ $namaLaboran }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @foreach ($laboranQuestions as $index => $question)
                                                            @php
                                                                $jawaban = collect($hasilSurvey['Laboran']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $question->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_laboran[{{ $question->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_laboran"><strong>Berikan saran dan komentar anda mengenai pelayanan Staf Laboran</strong></label>
                                                            <textarea name="saran_laboran" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3" style="text-align: left; vertical-align: top;">{{ $hasilSurvey['Laboran']['saran'] ?? '' }}</textarea>
                                                        </div>

                                                        {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="tambah-cpmk" onclick="addKepuasan()">Kirim Kuisioner</button>
                                                        </div> --}}
                                                        {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                        </div> --}}
                                                    {{-- </form> --}}
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-2" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
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
                                                    {{-- <form enctype="multipart/form-data" id="formSarprasTendikProdi"> --}}
                                                        @CSRF
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}"> --}}
                                                        {{-- <input type="hidden" name="survey_form_id" value="{{ $id_form_kepuasan }}"> --}}

                                                        <div class="form-group">
                                                            <label for="nama_staf_administrasi">Nama Staf Administrasi</label>
                                                            <select class="form-control" name="nama_staf_administrasi" id="nama_staf_administrasi" {{ $disable ? 'disabled' : '' }}>
                                                                @foreach ($staffAdmin as $namaStaff)
                                                                    <option value="{{ $namaStaff }}" {{ $nama_staff_admin == $namaStaff ? 'selected' : '' }}>{{ $namaStaff }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        @foreach ($staffAdminQuestions as $index => $questionAdmin)
                                                            @php
                                                                $jawaban_staf_admin = collect($hasilSurvey['Staf Administrasi']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $questionAdmin->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $questionAdmin->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_staf_administrasi[{{ $questionAdmin->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban_staf_admin == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_staf_administrasi"><strong>Saran</strong></label>
                                                            <textarea name="saran_staf_administrasi" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3">{{ $hasilSurvey['Staf Administrasi']['saran'] ?? '' }}</textarea>
                                                        </div>

                                                        {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                        </div> --}}
                                                    {{-- </form> --}}
                                                </div>
                                            </div>

                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-3" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
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
                                                    {{-- <form enctype="multipart/form-data" id="formSarprasTendikProdi"> --}}
                                                        @CSRF
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_kepuasan }}"> --}}

                                                        @foreach ($manajemenProdiQuestions as $index => $questionProdi)
                                                            @php
                                                                $jawaban_prodi = collect($hasilSurvey['Manajemen Prodi']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $questionProdi->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $questionProdi->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_manajemen_prodi[{{ $questionProdi->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban_prodi == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_manajemen_prodi"><strong>Saran</strong></label>
                                                            <textarea name="saran_manajemen_prodi" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3">{{ $hasilSurvey['Manajemen Prodi']['saran'] ?? '' }}</textarea>
                                                        </div>

                                                        {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                            <button class="btn btn-primary" type="button" id="simpan-cpmk-edit" style="display: none" onclick="saveEditedCpmk()"><i class="nav-icon fas fa-plus mr-2"></i>Simpan Data</button>
                                                        </div> --}}
                                                    {{-- </form> --}}
                                                </div>
                                            </div>

                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-4" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
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
                                                    {{-- <form enctype="multipart/form-data" id="formSarprasTendikProdi"> --}}
                                                        @CSRF
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_kepuasan }}"> --}}

                                                        @foreach ($visiMisiQuestions as $index => $questionVisiMisi)
                                                            @php
                                                                $jawaban_visi_misi = collect($hasilSurvey['Visi Misi']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $questionVisiMisi->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $questionVisiMisi->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_visi_misi[{{ $questionVisiMisi->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban_visi_misi == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_visi_misi"><strong>Berikan saran dan komentar Anda mengenai visi dan misi Prodi Arsitektur</strong></label>
                                                            <textarea name="saran_visi_misi" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3">{{ $hasilSurvey['Visi Misi']['saran'] ?? '' }}</textarea>
                                                        </div>

                                                        @foreach ($roadmapPenelitianQuestions as $index => $questionRoadmap)
                                                            @php
                                                                $jawaban_roadmap_penelitian = collect($hasilSurvey['Roadmap Penelitian']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $questionRoadmap->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $questionRoadmap->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_roadmap[{{ $questionRoadmap->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban_roadmap_penelitian == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="mb-3">
                                                            <label for="saran_roadmap"><strong>Berikan saran dan komentar anda mengenai Roadmap Penelitian dan Pengabdian Program Studi Arsitektur</strong></label>
                                                            <textarea name="saran_roadmap" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3">{{ $hasilSurvey['Roadmap Penelitian']['saran'] ?? '' }}</textarea>
                                                        </div>
                                                    {{-- </form> --}}
                                                </div>
                                            </div>

                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="stepper1.next()">Selanjutnya</button>
                                        </div>

                                        <div id="test-l-5" class="content" role="tabpanel" aria-labelledby="stepper1trigger2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{-- <form enctype="multipart/form-data" id="formKinerja"> --}}
                                                        @csrf
                                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_kinerja }}"> --}}

                                                        @foreach ($sarprasQuestions as $index => $questionSarpras)
                                                            @php
                                                                $jawaban_sarpras = collect($hasilSurvey['Sarpras']['pertanyaan'] ?? [])
                                                                    ->firstWhere('question_id', $questionSarpras->id)['skor_jawaban'] ?? null;
                                                            @endphp
                                                            <div class="mb-3">
                                                                <label><strong>{{ $index + 1 }}. {{ $questionSarpras->pertanyaan }}</strong></label><br>
                                                                @foreach ($options as $key => $label)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="jawaban_sarpras[{{ $questionSarpras->id }}]" value="{{ $key }}" {{ $disable ? 'disabled' : '' }} {{ $jawaban_sarpras == $key ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ $label }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach

                                                        <div class="form-group mt-3">
                                                            <label>Saran</label>
                                                            <textarea name="saran_sarpras" class="form-control" {{ $disable ? 'readonly' : '' }} rows="3">{{ $hasilSurvey['Sarpras']['saran'] ?? '' }}</textarea>
                                                        </div>
                                                        {{-- <div class="row justify-content-end"> --}}
                                                            {{-- <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                                                <button class="btn btn-primary" type="button" id="tambah-subcpmk" onclick="addKinerja()">Kirim Kuisioner</button>
                                                            </div> --}}
                                                        {{-- </div> --}}

                                                </div>
                                            </div>
                                            <div id="tabel-subcpmk"></div>
                                            <button class="btn btn-primary"
                                                onclick="stepper1.previous()">Sebelumnya</button>
                                                {{-- <button type="button" class="btn btn-primary" {{ $sudahIsi ? 'disabled' : '' }}
                                                onclick="simpan()">Simpan</button> --}}
                                                <button type="submit" class="btn btn-primary" {{ $sudahIsi ? 'disabled' : '' }}>Simpan</button>
                                            </form>
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

    $('#formSarprasTendikProdi').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);

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
                        window.location.href = "{{ route('mahasiswa.dashboard') }}";
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
    });


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
