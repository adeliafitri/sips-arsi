@extends('layouts.admin.main')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data RPS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Data RPS</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
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
                        <div class="card-header ">
                            <h3 class="card-title col align-self-center pl-0">Data RPS</h3>
                        </div>
                        <div class="card-body">
                            <h6 style="font-weight: bold">Kode Mata Kuliah :</h6>
                            <h6 style="font-weight: bold">Nama Mata Kuliah :</h6>
                            <h6 style="font-weight: bold">SKS :</h6>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card bg-section pb-1 bg-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px">
                        <ul class="nav nav-tabs justify-content-center" style="background-color: #007bff; border-top-left-radius: 8px; border-top-right-radius: 8px">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" data-toggle="pill" href="#cpl-tab"><h6 style="color: black; font-weight: bold">Data CPL</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#cpmk-tab"><h6 style="color: black; font-weight: bold">Data CPMK</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#subcpmk-tab"><h6 style="color: black; font-weight: bold">Data Sub CPMK</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#rps-tab"><h6 style="color: black; font-weight: bold">RPS</h6></a>
                            </li>
                        </ul>

                        <div class="tab-content bg-white px-3">
                            <div class="tab-pane show fade active justify-content-center" id="cpl-tab">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kode CPL</th>
                                            <th>Jenis CPL</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $key => $datas) --}}
                                        <tr>
                                            <td>1</td>
                                            <td>CPL1</td>
                                            <td>Jenis CPL1</td>
                                            <td>Deskripsi 1</td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="cpmk-tab">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kode CPL</th>
                                            <th>Jenis CPL</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $key => $datas) --}}
                                        <tr>
                                            <td>2</td>
                                            <td>CPL1</td>
                                            <td>Jenis CPL1</td>
                                            <td>Deskripsi 1</td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="subcpmk-tab">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kode CPL</th>
                                            <th>Jenis CPL</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $key => $datas) --}}
                                        <tr>
                                            <td>3</td>
                                            <td>CPL1</td>
                                            <td>Jenis CPL1</td>
                                            <td>Deskripsi 1</td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="rps-tab">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kode CPL</th>
                                            <th>Jenis CPL</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $key => $datas) --}}
                                        <tr>
                                            <td>4</td>
                                            <td>CPL1</td>
                                            <td>Jenis CPL1</td>
                                            <td>Deskripsi 1</td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

