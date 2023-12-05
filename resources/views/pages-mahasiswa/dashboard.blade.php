@extends('layouts.admin.main')

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
      <!-- Small boxes (Stat box) -->
      <!-- <div class="row"> -->
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Pengumuman</h5>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div>
      <!-- </div> -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
      <div class="col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>8</h3>

              <p>Jumlah Mata Kuliah</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-6">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Progress CPL Mahasiswa</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="mb-2">
              <p class="mb-0">CPL 1</p>
              <div class="progress">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                     aria-valuemax="100" style="width: 40%">
                  <span>40%</span>
                </div>
              </div>
              </div>
              <div class="mb-2">
              <p class="mb-0">CPL 2</p>
              <div class="progress">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                     aria-valuemax="100" style="width: 20%">
                  <span>20%</span>
                </div>
              </div>
              </div>
              <!-- <div class="progress mb-3">
                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                     aria-valuemax="100" style="width: 60%">
                  <span class="sr-only">60% Complete (warning)</span>
                </div>
              </div>
              <div class="progress mb-3">
                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                     aria-valuemax="100" style="width: 80%">
                  <span class="sr-only">80% Complete</span>
                </div>
              </div> -->
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- PIE CHART -->
        <div class="col-md-6">
        <div class="card card-info ml-2">
            <div class="card-header">
              <h3 class="card-title">Penilaian Mahasiswa</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> -->
              </div>
            </div>
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

          <div class="col-md-6">
          <div class="card card-info ml-2">
            <div class="card-header">
              <h3 class="card-title">Data SKS Mahasiswa</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> -->
              </div>
            </div>
            <div class="card-body">
              <canvas id="myPieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
          </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
