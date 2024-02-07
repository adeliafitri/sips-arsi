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
                            <h6> <span style="font-weight: bold"> Kode Mata Kuliah : </span>  {{ $data->kode_matkul }}</h6>
                            <h6> <span style="font-weight: bold"> Nama Mata Kuliah : </span> {{ $data->nama_matkul }}</h6>
                            <h6> <span style="font-weight: bold" onclick="loadCPL(1);"> SKS : </span> {{ $data->sks }}</h6>

                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card bg-section pb-1 bg-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px">
                        <ul class="nav nav-tabs justify-content-center" style="background-color: #007bff; border-top-left-radius: 8px; border-top-right-radius: 8px">
                            <li class="nav-item">
                                <a class="nav-link active" role="tab" data-toggle="pill" href="#cpl-tab" aria-controls="cpl-tab" aria-selected="true" onclick="detailCpl({{ $data->id }});" ><h6  style="color: black; font-weight: bold">Data CPL</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="tab"  data-toggle="pill" href="#cpmk-tab" aria-controls="cpmk-tab" aria-selected="false" onclick="detailCpmk({{ $data->id }});"><h6 style="color: black; font-weight: bold">Data CPMK</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="tab"  data-toggle="pill" href="#subcpmk-tab" aria-controls="subcpmk-tab" aria-selected="false" onclick="detailSubCpmk({{ $data->id }});"><h6 style="color: black; font-weight: bold">Data Sub CPMK</h6></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" role="tab"  data-toggle="pill" href="#rps-tab" aria-controls="rps-tab" aria-selected="false" onclick="detailTugas({{ $data->id }});"><h6 style="color: black; font-weight: bold">Tugas</h6></a>
                            </li>
                        </ul>
                        

                        <div class="tab-content bg-white px-3">
                            <div class="tab-pane show fade active justify-content-center" id="cpl-tab" role="tabpanel">
                                <div id="cpl">
                                </div>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="cpmk-tab" role="tabpanel">
                                <div id="cpmk">
                                </div>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="subcpmk-tab" role="tabpanel">
                                <div id="sub-cpmk">
                                </div>
                            </div>

                            <div class="tab-pane fade justify-content-center" id="rps-tab" role="tabpanel">
                                <div id="tugas">
                                </div>
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

@section('script')
    <script>
        function detailCpl(id){
            $.ajax({
                    url: "{{ url('admin/mata-kuliah/detail/cpl') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(data) {
                    // Insert the table into the #cpl-tab element
                    $('#cpl').html(data);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
        }

        function detailCpmk(id){
            $.ajax({
                    url: "{{ url('admin/mata-kuliah/detail/cpmk') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(data) {
                    // Insert the table into the #cpl-tab element
                    $('#cpmk').html(data);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
        }

        function detailSubCpmk(id){
            $.ajax({
                    url: "{{ url('admin/mata-kuliah/detail/sub-cpmk') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(data) {
                    // Insert the table into the #cpl-tab element
                    $('#sub-cpmk').html(data);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
        }

        function detailTugas(id){
            $.ajax({
                    url: "{{ url('admin/mata-kuliah/detail/tugas') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(data) {
                    // Insert the table into the #cpl-tab element
                    $('#tugas').html(data);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
        }

        $(document).ready(function() {
                detailCpl({{ $data->id }});
        });
    </script>
@endsection

