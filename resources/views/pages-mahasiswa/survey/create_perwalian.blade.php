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
                        <li class="breadcrumb-item active">Survey Kepuasan Mahasiswa Terhadap Perwalian</li>
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
                            <h3 class="card-title col align-self-center">Survey Kepuasan Mahasiswa Terhadap Perwalian</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="col-md-12">
                                    <form enctype="multipart/form-data" id="formPerwalian">
                                        @CSRF
                                        {{-- <input type="hidden" name="matakuliah_kelas_id" value="{{ $matakuliah_kelas_id }}">
                                        <input type="hidden" name="dosen_id" value="{{ $dosen_id }}"> --}}
                                        <input type="hidden" name="survey_form_id" value="{{ $id_form_perwalian }}">

                                        <div class="form-group">
                                            <label for="dosen_id">Dosen Wali</label>
                                            <select class="form-control select2bs4" id="dosen_id" name="dosen_id">
                                                <option value="">- Pilih Dosen -</option>
                                                @foreach ($dosen as $id => $name)
                                                      <option value="{{ $id }}">{{ $name }}</option>
                                                  @endforeach
                                            </select>
                                        </div>

                                        @foreach ($perwalianQuestions as $index => $question)
                                            <div class="mb-3">
                                                <label><strong>{{ $index + 1 }}. {{ $question->pertanyaan }}</strong></label><br>
                                                @foreach ($options as $key => $label)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban_perwalian[{{ $question->id }}]" value="{{ $key }}" required>
                                                        <label class="form-check-label">{{ $label }}</label>
                                                    </div>
                                                 @endforeach
                                            </div>
                                        @endforeach

                                        <div class="mb-3">
                                            <label for="saran_perwalian"><strong>Saran</strong></label>
                                            <textarea name="saran_perwalian" class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="col-md-12 d-flex justify-content-end" style="margin-bottom: 1rem">
                                            <button class="btn btn-primary" type="button" id="tambah-cpmk" onclick="addPerwalian()">Kirim Kuisioner</button>
                                        </div>
                                    </form>
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
    //content goes here
    });

    function addPerwalian() {
        var form = $('#formPerwalian');
        $.ajax({
            type: 'POST',
            url: "{{ url('mahasiswa/survey/simpan-perwalian') }}/",
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
                        if (result.isConfirmed) {
                            // Redirect to the desired URL
                            window.location.href = "{{ route('mahasiswa.dashboard') }}";
                        };
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
</script>
@endsection
