@extends('layouts.admin.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Evaluasi Survei Perwalian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
              <li class="breadcrumb-item active">Evaluasi Survei Perwalian</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Filter -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="" class="row align-items-end" id="filterForm">
                        <div class="col-md-6">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-control" onchange="submitFilter()">
                                @foreach($listTahun as $tahunAjaran)
                                    <option value="{{ $tahunAjaran }}" {{ request('tahun_ajaran', $tahun) == $tahunAjaran ? 'selected':'' }}>
                                    {{ $tahunAjaran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Semester</label>
                            <select name="semester" class="form-control" onchange="submitFilter()">
                            <option value="">-- Semua --</option>
                            <option value="ganjil"  {{ request('semester', $semester) == 'ganjil' ?'selected':'' }}>Ganjil</option>
                            <option value="genap" {{ request('semester', $semester) == 'genap' ?'selected':'' }}>Genap</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Horizontal Bar Chart -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="text-center">Jumlah Responden per Dosen</h5>
                    <div style="height:300px;">
                        <canvas id="barResponden"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Charts -->
            <div class="row">
                @foreach($pieData as $kategori => $data)
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                    <div class="card-body">
                        <h5 class="text-center">{{ $kategori }}</h5>
                        <div style="height:300px;">
                            <canvas id="pie_{{ strtolower(str_replace(' ', '-', $kategori)) }}"></canvas>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function submitFilter() {
        document.getElementById('filterForm').submit();
    }
    document.addEventListener('DOMContentLoaded', function () {
        const barLabels = @json($barLabels);
        const barValues = @json($barValues);

        const ctxBar = document.getElementById('barResponden');

        new Chart(ctxBar, {
            type: 'horizontalBar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Jumlah Responden',
                    data: barValues ,
                    barThickness: 20,
                    maxBarThickness: 25,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        const pieData = @json($pieData);

        Object.keys(pieData).forEach((kategori) => {

            const canvasId = 'pie_' + kategori.toLowerCase().replace(/\s+/g, '-');
            const ctx = document.getElementById(canvasId);

            const dataCount = pieData[kategori].count;
            const dataPercent = pieData[kategori].percent;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        `Sangat Baik (${dataPercent['Sangat Baik']}%)`,
                        `Baik (${dataPercent['Baik']}%)`,
                        `Cukup (${dataPercent['Cukup']}%)`,
                        `Kurang (${dataPercent['Kurang']}%)`
                    ],
                    datasets: [{
                        data: dataCount,
                        backgroundColor: ['#4CAF50','#2196F3','#FFC107','#F44336']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    });
</script>
