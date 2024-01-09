@extends('layouts.admin.main')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa') }}">Data Mahasiswa</a></li>
                        <li class="breadcrumb-item active">Edit Data</li>
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
                            <h3 class="card-title col align-self-center">Form Edit Data Mahasiswa</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.mahasiswa.update', ['id' => $data->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        placeholder="NIM" value="{{ $data->nim }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Nama" value="{{ $data->nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="text" class="form-control" name="angkatan" id="angkatan" required
                                        placeholder="Angkatan" value="{{ $data->angkatan }}">
                                </div>
                                <div class="form-group">
                                    <label for="telp">No Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp"
                                        placeholder="No Telepon" value="{{ $data->telp }}">
                                </div>
                                {{-- <div class="row">
                                    <div class="form-group col-8">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            @php
                                                $formattedDate = $data->tanggal_lahir ? date('d/m/Y', strtotime($data->tanggal_lahir)) : '';
                                            @endphp
                                            <input type="text" class="form-control datetimepicker-input"
                                                id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir"
                                                data-target="#reservationdate" value="{{ $formattedDate }}" />
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="jenis_kelamin">Jenis Kelamin</label> <br>
                                        <input type="radio" name="jenis_kelamin" value="L"
                                            @if ($data->jenis_kelamin == 'L') checked @endif> Laki-laki
                                        <input type="radio" name="jenis_kelamin" value="P"
                                            @if ($data->jenis_kelamin == 'P') checked @endif> Perempuan
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" rows="2">{{ $data->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telp">No Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp"
                                        placeholder="No Telepon" value="{{ $data->telp }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="image"
                                            name="file">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" rows="3" name="email"
                                        placeholder="Email" value="{{ $data->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" rows="3"
                                        name="password" placeholder="Password">
                                    <small class="text-danger">Tidak wajib diisi jika tidak ingin mengubah password</small>
                                </div> --}}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.mahasiswa') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
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
