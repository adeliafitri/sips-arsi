@extends('layouts.dosen.main')

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" alt="Logo Arsitektur UIN Maulana Malik Ibrahim Malang" height="60" width="60">
  </div>

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- <div class="row"> -->
        <!-- Small boxes (Stat box) -->
    <div class="row">
        @php
            $colors = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
        @endphp
        @foreach ($data as $key => $datas)
        <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box {{ $colors[$key % count($colors)] }}">
              <div class="inner">
                <h3>{{ $key+1 }}</h3>

                <p>{{ $datas->nama_matkul }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('dosen.matakuliah.show', $datas->id_matkul) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        @endforeach
    </div>
    <!-- /.row -->
      <!-- </div> -->
      <!-- /.row -->
      <!-- Main row -->

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
  <script>
    $(function () {

    });
  </script>
