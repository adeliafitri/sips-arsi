<?php
// if(isset($_GET['data'])){
// 	$id_kelas_kuliah = $_GET['data'];
// 	//gat data berita
//   $sql = "SELECT `mk`.`id`, `mk`.`tahun_ajaran`, `mk`.`semester`, `k`.`nama_kelas`, `m`.`nama_matkul`, `d`.`nama` FROM `matakuliah_kelas` `mk` INNER JOIN `kelas` `k` ON `mk`.`kelas_id` = `k`.`id` INNER JOIN `matakuliah` `m` ON `mk`.`matakuliah_id` = `m`.`id` INNER JOIN `dosen` `d` ON `mk`.`dosen_id` = `d`.`id` WHERE `mk`.`id`='$id_kelas_kuliah'";
//   $query = mysqli_query($koneksi,$sql);
//   while($data = mysqli_fetch_row($query)){
//     $id_kelas_kuliah= $data[0];
//     $tahun_ajaran= $data[1];
//     $semester = $data[2];
//     $nama_kelas= $data[3];
//     $nama_matkul = $data[4];
//     $nama_dosen = $data[5];
//   }
// }
?>

<!-- Content Header (Page header) -->
{{-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo "Kelas $nama_kelas - $nama_matkul";?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?include=data-kelas-perkuliahan">Data Kelas Perkuliahan</a></li>
              <li class="breadcrumb-item active"><?php echo "$nama_kelas - $nama_matkul";?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> --}}
    <!-- /.content-header -->

   <!-- Main content -->
{{-- <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Kelas</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
            <p><span class="text-bold">Semester :</span> <?php echo $semester;?></p>
            <p><span class="text-bold">Tahun Ajaran :</span> <?php echo $tahun_ajaran;?></p>
            <p><span class="text-bold">Dosen :</span> <?php echo $nama_dosen;?></p>
            <p><span class="text-bold">Jumlah Mahasiswa(Aktif) :</span> 15</p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

            <div class="card">
              <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-10">
                  <form action="product.php?aksi=cari" method="post">
                    <div class="input-group col-sm-4 mr-3">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- <h3 class="card-title col align-self-center">List Products</h3> -->
                <div class="col-sm-2">
                    <a href="index.php?include=detail-kelas-perkuliahan&data=<?php echo $id_kelas_kuliah?>&include=tambah-daftar-mahasiswa" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div>
              </div>
              <div class="card-body">
              <div class="col-sm-12 mt-3">
                  <?php if(!empty($_GET['notif'])){?>
                      <?php if($_GET['notif']=="tambahberhasil"){?>
                          <div class="alert alert-success bg-success text-white" role="alert">
                          Data Berhasil Ditambahkan</div>
                      <?php } else if($_GET['notif']=="editberhasil"){?>
                          <div class="alert alert-success bg-success text-white" role="alert">
                          Data Berhasil Diubah</div>
                      <?php } else if($_GET['notif']=="hapusberhasil"){?>
                          <div class="alert alert-success bg-success text-white" role="alert">
                          Data Berhasil Dihapus</div>
                      <?php }?>
                  <?php }?>
              </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th style="width: 250px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $batas = 10;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }
                    $sql_b = "SELECT DISTINCT `n`.`mahasiswa_id`, `m`.`nama`, `m`.`nim` FROM `nilaimahasiswa` `n` INNER JOIN `mahasiswa` `m` ON `n`.`mahasiswa_id` = `m`.`id` WHERE `n`.`matakuliah_kelasid` = '$id_kelas_kuliah'";
                    if (isset($search) && !empty($search)) {
                        $sql_b .= " AND `m`.`nim` LIKE '%$search%' || `m`.`nama` LIKE '%$search%' ";
                    }
                    $sql_b .= " ORDER BY `m`.`nim`, `m`.`nama` limit $posisi, $batas";
                    $query_b = mysqli_query($koneksi,$sql_b);
                    $no = $posisi+1;
                    while($data_b = mysqli_fetch_row($query_b)){
                        $id_mahasiswa= $data_b[0];
                        $nama_mahasiswa = $data_b[1];
                        $nim = $data_b[2];
                  ?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo $nim?></td>
                        <td><?php echo $nama_mahasiswa?></td>
                        <td>
                            <!-- <a href="index.php?include=detail-daftar-mahasiswa" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                            <!-- <a href="index.php?include=include=detail-kelas-perkuliahan&data=<?php echo $id_kelas_kuliah;?>&include=edit-daftar-mahasiswa&id_mahasiswa=<?php echo $id_mahasiswa?>" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a> -->
                            <a href="javascript:if(confirm('Anda yakin ingin menghapus data?')) window.location.href = 'index.php?include=detail-kelas-perkuliahan&data=<?php echo $id_kelas_kuliah;?>&id_mahasiswa=<?php echo $id_mahasiswa?>&notif=hapusberhasil'" class="btn btn-danger mt-1"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</a>
                        </td>
                    </tr>
                    <?php $no++; }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <?php
                    $sql_b = "SELECT DISTINCT `n`.`mahasiswa_id`, `m`.`nama`, `m`.`nim` FROM `nilaimahasiswa` `n` INNER JOIN `mahasiswa` `m` ON `n`.`mahasiswa_id` = `m`.`id` WHERE `n`.`matakuliah_kelasid` = '$id_kelas_kuliah'";
                    if (isset($search) && !empty($search)) {
                        $sql_b .= " AND `m`.`nim` LIKE '%$search%' || `m`.`nama` LIKE '%$search%' ";
                    }
                    $sql_b .= " ORDER BY `m`.`nim`, `m`.`nama`";
                    // $query_b = mysqli_query($koneksi,$sql_b);
                    $query_jum = mysqli_query($koneksi,$sql_b);
                    $jum_data = mysqli_num_rows($query_jum);
                    $jum_halaman = ceil($jum_data/$batas);
              ?>

              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <?php
                    if ($jum_halaman == 0) {
                      //nothing page
                    }elseif ($jum_halaman == 1) {
                      echo "<li class='page-item'><a class='page-link'>1</a></li>";
                    }else {
                      $prev = $halaman-1;
                      $next = $halaman+1;
                      if ($halaman!=1) {
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-kelas-perkuliahan&halaman=1'>First</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-kelas-perkuliahan&halaman=$prev'>&laquo;</a></li>";
                      }
                      for ($i=1; $i <= $jum_halaman; $i++) {
                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                          if ($i != $halaman) {
                            echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-kelas-perkuliahan&halaman=$i'>$i</a></li>";
                          } else {
                            echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                          }
                        }
                      }
                      if ($halaman!=$jum_halaman) {
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-kelas-perkuliahan&halaman=$next'>&raquo;</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-kelas-perkuliahan&halaman=$jum_halaman'>Last</a></li>";
                      }
                    }
                  ?>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</section> --}}
<!-- /.content --> 

@extends('layouts.dosen.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelas {{ $data->kelas }} - {{ $data->nama_matkul }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dosen.kelaskuliah') }}">Data Kelas Perkuliahan</a></li>
              <li class="breadcrumb-item active">{{ $data->kelas }} - {{ $data->nama_matkul }}</li>
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
          <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Kelas</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
            <p><span class="text-bold">Semester :</span> {{ $data->semester }}</p>
            <p><span class="text-bold">Tahun Ajaran :</span> {{ $data->tahun_ajaran }}</p>
            <p><span class="text-bold">Dosen :</span> {{ $data->nama_dosen }}</p>
            <p><span class="text-bold">Jumlah Mahasiswa(Aktif) :</span> {{ $jumlah_mahasiswa->jumlah_mahasiswa }}</p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
            <div class="card">
              <div class="card-header d-flex col-sm-12 justify-content-between">
                <div class="col-8">
                  <form action="{{ route('dosen.kelaskuliah.show', $data->id) }}" method="GET">
                    <div class="input-group col-sm-6 mr-3">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- <h3 class="card-title col align-self-center">List Products</h3> -->
                <div class="dropdown col-sm-2">
                    <button class="btn btn-success w-100 dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-excel mr-2"></i> Excel
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#"><i class="fas fa-upload mr-2"></i> Export</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-download mr-2"></i> Import</a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a href="{{ route('dosen.kelaskuliah.createmahasiswa', $data->id) }}" class="btn btn-primary w-100"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div>
              </div>
              <div class="card-body">
              <div class="col-sm-12 mt-3">
                @if (session('success'))
                    <div class="alert alert-success bg-success" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger bg-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
              </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>NIM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Nilai Akhir</th>
                      <th>Keterangan</th>
                      <th style="width: 150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($mahasiswa as $key => $mahasiswas)
                    <tr>
                        <td>{{ $startNumber++ }}</td>
                        <td>{{ $mahasiswas->nim }}</td>
                        <td>{{ $mahasiswas->nama }}</td>
                        <td>{{ $mahasiswas->nilai_akhir }}</td>
                        <td>{{ $keterangan[$mahasiswas->id] }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('dosen.kelaskuliah.nilaimahasiswa', ['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" class="btn btn-info mr-2"><i class="nav-icon far fa-eye"></i></a>
                                <form action="{{ route('dosen.kelaskuliah.destroymahasiswa',['id' => $data->id, 'id_mahasiswa' => $mahasiswas->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit"><i class="nav-icon fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <div class="float-right">
                        {{ $mahasiswa->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </ul>
              </div>
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







