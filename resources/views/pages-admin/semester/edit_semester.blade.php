@extends('layouts.admin.main')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Data Semester</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.semester') }}">Data Semester</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="col-12 justify-content-center">
                            @if($errors->any())
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
                            <h3 class="card-title col align-self-center">Form Edit Data Semester</h3>
                        </div>
                        <form action="{{ route('admin.semester.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                @CSRF
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran </label>
                                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Tahun Ajaran" value="{{ $data->tahun_ajaran }}">
                                </div>
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <div class="row col-3">
                                        <div class="col-6" class="align-middle">
                                            <input type="radio" id="ganjil" name="semester" value="ganjil" {{ $data->semester == 'ganjil' ? 'checked' : '' }}>
                                            <label for="ganjil" class="radio-label text-box">
                                                Ganjil
                                            </label>
                                        </div>
                                        <div class="col-6" class="align-middle">
                                            <input type="radio" id="genap" name="semester" value="genap" {{ $data->semester == 'genap' ? 'checked' : '' }}>
                                            <label for="genap" class="radio-label text-box">
                                                Genap
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <input type="text" class="form-control" id="semester" name="semester" placeholder="Semester"> --}}
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('admin.semester') }}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection