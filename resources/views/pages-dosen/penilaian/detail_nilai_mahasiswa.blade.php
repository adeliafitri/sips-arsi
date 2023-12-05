<?php
if(isset($_GET['data'])){
	$id_kelas_kuliah = $_GET['data'];
  $id_mahasiswa = $_GET['id_mahasiswa'];
	//gat data berita
  $sql = "SELECT `n`.`mahasiswa_id`, `m`.`nama`, `m`.`nim`, `mk`.`nama_matkul` FROM `nilaimahasiswa` `n` INNER JOIN `mahasiswa` `m` ON `n`.`mahasiswa_id` = `m`.`id` INNER JOIN `matakuliah_kelas` `k` ON `n`.`matakuliah_kelasid` = `k`.`id` INNER JOIN `matakuliah` `mk` ON `k`.`matakuliah_id` = `mk`.`id` WHERE `n`.`mahasiswa_id`='$id_mahasiswa' AND `n`.`matakuliah_kelasid` = '$id_kelas_kuliah'";
  $query = mysqli_query($koneksi,$sql);
  while($data = mysqli_fetch_row($query)){
    $id_mahasiswa= $data[0];
    $nama_mahasiswa= $data[1];
    $nim= $data[2];
    $nama_matkul= $data[3];
  }
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Nilai Mahasiswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?include=nilai-mahasiswa">Data Nilai</a></li>
              <li class="breadcrumb-item active">Nilai Mahasiswa</li>
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
          <h3 class="card-title">Detail Nilai <?php echo $nama_matkul;?></h3>

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
            <div class="row">
            <div class="col-6">
            <p><span class="text-bold">Nama :</span> <?php echo $nama_mahasiswa;?></p>
            <p><span class="text-bold">NIM :</span> <?php echo $nim;?></p>
            <p><span class="text-bold">Nilai Akhir :</span> 90 <a href="index.php?include=edit-nilai-akhir"><i class="nav-icon fas fa-edit ml-2"></i></a></p>
            </div>
            <div class="col-3">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h6 class="box-title">Capaian CPMK Mahasiswa</h6>
                                </div>
                                <div class="box-body">
                                    <canvas id="radarCpmkMahasiswa" style="height: 100px; width:100px;"></canvas>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="downloadButton" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Unduh</button>
                            </div>
                        </div>
            </div>
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
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=tambah-daftar-mahasiswa" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> -->
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Minggu</th>
                      <th>Nama Sub-CPMK</th>
                      <th>Bentuk Soal</th>
                      <th>Bobot Sub-CPMK</th>
                      <th>Nilai</th>
                      <th style="width: 250px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $batas = 5;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }
                    $sql_b = "SELECT `n`.`subcpmk_id`, `s`.`waktu_pelaksanaan`, `s`.`nama_subcpmk`, `s`.`bobot_subcpmk`, `s`.`bentuk_soal`, `n`.`nilai` FROM `nilaimahasiswa` `n` INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id` WHERE `n`.`matakuliah_kelasid` = '$id_kelas_kuliah' AND `n`.`mahasiswa_id`='$id_mahasiswa'";
                    if (isset($search) && !empty($search)) {
                        $sql_b .= " AND `s`.`nama_subcpmk` LIKE '%$search%' || `s`.`bentuk_soal` LIKE '%$search%' ";
                    }
                    $sql_b .= " ORDER BY `n`.`id` limit $posisi, $batas";
                    $query_b = mysqli_query($koneksi,$sql_b);
                    $no = $posisi+1;
                    while($data_b = mysqli_fetch_row($query_b)){
                        $id_subcpmk= $data_b[0];
                        $minggu= $data_b[1];
                        $nama_subcpmk = $data_b[2];
                        $bobot_subcpmk = $data_b[3];
                        $bentuk_soal = $data_b[4];
                        $nilai = $data_b[5];
                  ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $minggu;?></td>
                        <td><?php echo $nama_subcpmk;?></td>
                        <td><?php echo $bentuk_soal;?></td>
                        <td><?php echo $bobot_subcpmk;?>%</td>
                        <td><?php echo $nilai;?></td>
                        <td>
                            <!-- <a href="index.php?include=detail-daftar-mahasiswa" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a> -->
                            <a href="index.php?include=edit-nilai-mahasiswa&data=<?php echo $id_kelas_kuliah;?>&id_mahasiswa=<?php echo $id_mahasiswa;?>&id_subcpmk=<?php echo $id_subcpmk;?>" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a>
                            <!-- <a href="javascript:if(confirm('Anda yakin ingin menghapus data?')) window.location.href = 'index.php?include=detail-kelas-perkuliahan&notif=hapusberhasil'" class="btn btn-danger mt-1"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</a> -->
                        </td>
                    </tr>
                  <?php  $no++; }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <?php
                $sql_b = "SELECT `n`.`subcpmk_id`, `s`.`waktu_pelaksanaan`, `s`.`nama_subcpmk`, `s`.`bobot_subcpmk`, `s`.`bentuk_soal`, `n`.`nilai` FROM `nilaimahasiswa` `n` INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id` WHERE `n`.`matakuliah_kelasid` = '$id_kelas_kuliah' AND `n`.`mahasiswa_id`='$id_mahasiswa'";
                if (isset($search) && !empty($search)) {
                    $sql_b .= " AND `s`.`nama_subcpmk` LIKE '%$search%' || `s`.`bentuk_soal` LIKE '%$search%' ";
                }
                $sql_b .= " ORDER BY `n`.`id`";
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
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa;?>&halaman=$prev'>&laquo;</a></li>";
                }
                for ($i=1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                    if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=$i'>$i</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                    }
                    }
                }
                if ($halaman!=$jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=$next'>&raquo;</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa= $id_mahasiswa&halaman=$jum_halaman'>Last</a></li>";
                }
                }
                ?>
                </ul>
                </div>
            </div>
            <!-- /.card -->

            <h5 class="text-bold text-center">Nilai Berdasarkan Sub-CPMK</h5>
             <!-- /.card -->

             <div class="card">
              <!-- <div class="card-header d-flex col-sm-12 justify-content-between">
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
                </div>  -->
                <!-- <h3 class="card-title col align-self-center">List Products</h3> -->
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=tambah-daftar-mahasiswa" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
                </div> -->
              <!-- </div> -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>CPL</th>
                      <th>CPMK</th>
                      <th>Sub-CPMK</th>
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <!-- <th style="width: 250px;">Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $batas = 5;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }
                    $sql_sub = "SELECT `c`.`kode_cpl`, `ck`.`kode_cpmk`, `s`.`nama_subcpmk`, SUM(`s`.`bobot_subcpmk`) as `bobot`, AVG(`n`.`nilai`) as `nilai`
                    FROM `nilaimahasiswa` `n` inner JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                    INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                    INNER JOIN `cpl` `c` ON `ck`.`cpl_id` = `c`.`id`
                    group by `c`.`kode_cpl`, `ck`.`kode_cpmk`, `s`.`nama_subcpmk` limit $posisi, $batas";
                    $query_sub = mysqli_query($koneksi,$sql_sub);
                    $no = $posisi+1;
                    while($data_sub = mysqli_fetch_row($query_sub)){
                        $kode_cpl= $data_sub[0];
                        $kode_cpmk= $data_sub[1];
                        $nama_subcpmk = $data_sub[2];
                        $bobot_subcpmk = $data_sub[3];
                        $nilai = $data_sub[4];
                  ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $kode_cpl;?></td>
                        <td><?php echo $kode_cpmk;?></td>
                        <td><?php echo $nama_subcpmk;?></td>
                        <td><?php echo $bobot_subcpmk;?></td>
                        <td>
                          <?php echo $nilai;?>
                        </td>
                    </tr>
                    <?php  $no++; }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <?php
                $sql_sub = "SELECT `c`.`kode_cpl`, `ck`.`kode_cpmk`, `s`.`nama_subcpmk`, SUM(`s`.`bobot_subcpmk`) as `bobot`, AVG(`n`.`nilai`) as `nilai`
                FROM `nilaimahasiswa` `n` inner JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                INNER JOIN `cpl` `c` ON `ck`.`cpl_id` = `c`.`id`
                where `n`.`mahasiswa_id` = '' and `n`.`matakuliah_kelasid` = 1
                group by `c`.`kode_cpl`, `ck`.`kode_cpmk`, `s`.`nama_subcpmk`";
                // $query_b = mysqli_query($koneksi,$sql_b);
                $query_jum = mysqli_query($koneksi,$sql_sub);
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
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa;?>&halaman=$prev'>&laquo;</a></li>";
                }
                for ($i=1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                    if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=$i'>$i</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                    }
                    }
                }
                if ($halaman!=$jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa=$id_mahasiswa&halaman=$next'>&raquo;</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='index.php?include=detail-nilai-mahasiswa&data=$id_kelas_kuliah&id_mahasiswa= $id_mahasiswa&halaman=$jum_halaman'>Last</a></li>";
                }
                }
                ?>
                </ul>
                </div>
            </div>
            <!-- /.card -->

            <h5 class="text-bold text-center">Nilai Berdasarkan CPMK</h5>
             <!-- /.card -->

             <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>CPL</th>
                      <th>CPMK</th>
                      <!-- <th>Sub-CPMK</th> -->
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <!-- <th style="width: 250px;">Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $batas = 5;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }
                    $sql_cpmk = "SELECT
                    `c`.`kode_cpl`, `ck`.`kode_cpmk`,
                    SUM(`s`.`bobot_subcpmk`)/COUNT(DISTINCT `s`.`bentuk_soal`) AS `bobot`,
                    AVG(`subquery`.`avg_nilai`) AS `avg_nilai`
                    FROM `nilaimahasiswa` `n` inner JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                    INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                    INNER JOIN `cpl` `c` ON `ck`.`cpl_id` = `c`.`id`
                    INNER JOIN (
                      SELECT
                        `ck`.`kode_cpmk`,
                        `s`.`bentuk_soal`,
                        AVG(CAST(`n`.`nilai` AS DECIMAL(10,2))) AS `avg_nilai`
                      FROM
                        `nilaimahasiswa` `n`
                        INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                        INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                      WHERE
                        `n`.`matakuliah_kelasid` = 1 AND `n`.`mahasiswa_id` = 2
                      GROUP BY
                        `ck`.`kode_cpmk`, `s`.`bentuk_soal`
                    ) `subquery` ON `ck`.`kode_cpmk` = `subquery`.`kode_cpmk`
                    WHERE `n`.`matakuliah_kelasid` = '$id_kelas_kuliah' AND `n`.`mahasiswa_id`='$id_mahasiswa'
                    group by `c`.`kode_cpl`, `ck`.`kode_cpmk` limit $posisi, $batas";
                    $query_cpmk = mysqli_query($koneksi,$sql_cpmk);
                    $no = $posisi+1;
                    while($data_cpmk = mysqli_fetch_row($query_cpmk)){
                        $kode_cpl= $data_cpmk[0];
                        $kode_cpmk= $data_cpmk[1];
                        // $nama_cpmkcpmk = $data_cpmk[2];
                        $bobot_cpmk = $data_cpmk[2];
                        $nilai = $data_cpmk[3];
                  ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $kode_cpl;?></td>
                        <td><?php echo $kode_cpmk;?></td>
                        <!-- <td>Sub-CPMK 2</td> -->
                        <td><?php echo $bobot_cpmk;?>%</td>
                        <td><?php echo number_format($nilai,2);?></td>
                    </tr>
                    <?php  $no++; }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <!-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <?php
                    if ($amountPage == 0) {
                      //nothing page
                    }elseif ($amountPage == 1) {
                      echo "<li class='page-item'><a class='page-link'>1</a></li>";
                    }else {
                      $prev = $page-1;
                      $next = $page+1;
                      if ($page!=1) {
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=1'>First</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$prev'>&laquo;</a></li>";
                      }
                      for ($i=1; $i <= $amountPage; $i++) {
                        if ($i > $page - 5 and $i < $page + 5) {
                          if ($i != $page) {
                            echo "<li class='page-item'><a class='page-link' href='product.php?page=$i'>$i</a></li>";
                          } else {
                            echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                          }
                        }
                      }
                      if ($page!=$amountPage) {
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$next'>&raquo;</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$amountPage'>Last</a></li>";
                      }
                    }
                  ?>
                </ul>
              </div> -->
            </div>
            <!-- /.card -->

            <h5 class="text-bold text-center">Nilai Berdasarkan CPL</h5>
             <!-- /.card -->

             <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>CPL</th>
                      <th>Bobot</th>
                      <th>Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $batas = 5;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }
                    $sql_cpl = "  SELECT
                    `c`.`kode_cpl`,
                    SUM(`s`.`bobot_subcpmk`)/COUNT(DISTINCT `s`.`bentuk_soal`) AS `bobot`,
                    AVG(`subquery`.`avg_nilai`) AS `avg_nilai`
                  FROM
                    `nilaimahasiswa` `n`
                    INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                    INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                    INNER JOIN `cpl` `c` ON `ck`.`cpl_id` = `c`.`id`
                    INNER JOIN (
                      SELECT
                        `cpl`.`kode_cpl`,
                        `s`.`bentuk_soal`,
                        AVG(CAST(`n`.`nilai` AS DECIMAL(10,2))) AS `avg_nilai`
                      FROM
                        `nilaimahasiswa` `n`
                        INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                        INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                        INNER JOIN `cpl` `cpl` ON `ck`.`cpl_id` = `cpl`.`id`
                      WHERE
                        `n`.`matakuliah_kelasid` = 1 AND `n`.`mahasiswa_id` = 2
                      GROUP BY
                        `cpl`.`kode_cpl`, `s`.`bentuk_soal`
                    ) `subquery` ON `c`.`kode_cpl` = `subquery`.`kode_cpl`
                  WHERE
                    `n`.`matakuliah_kelasid` = 1 AND `n`.`mahasiswa_id` = 2
                  GROUP BY
                    `c`.`kode_cpl` limit $posisi, $batas";
                    $query_cpl = mysqli_query($koneksi,$sql_cpl);
                    $no = $posisi+1;
                    while($data_cpl = mysqli_fetch_row($query_cpl)){
                        $kode_cpl= $data_cpl[0];
                        // $kode_cpmk= $data_cpl[1];
                        // $nama_cplcpmk = $data_cpl[2];
                        $bobot_cpmk = $data_cpl[1];
                        $nilai = $data_cpl[2];
                  ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $kode_cpl;?></td>
                        <!-- <td>CPMK 2</td> -->
                        <!-- <td>Sub-CPMK 2</td> -->
                        <td>
                          <?php
                  //         $bobot = "SELECT SUM(`s`.`bobot_subcpmk`) as `bobot`FROM
                  //         `nilaimahasiswa` `n`
                  //         INNER JOIN `sub_cpmk` `s` ON `n`.`subcpmk_id` = `s`.`id`
                  //         INNER JOIN `cpmk` `ck` ON `s`.`cpmk_id` = `ck`.`id`
                  //         INNER JOIN `cpl` `c` ON `ck`.`cpl_id` = `c`.`id` WHERE
                  //   `n`.`matakuliah_kelasid` = 1 AND `n`.`mahasiswa_id` = 2
                  // GROUP BY
                  //   `c`.`kode_cpl` limit $posisi, $batas";
                  //   $query_bobot = mysqli_query($koneksi,$bobot);
                  //   // $no = $posisi+1;
                  //   $data_bobot = mysqli_fetch_row($query_bobot);
                  //       $bobot_cpmk= $data_bobot[0];
                        // $kode_cpmk= $data_cpl[1];
                        // $nama_cplcpmk = $data_cpl[2];
                        // $bobot_cpmk = $data_cpl[1];
                        // $nilai = $data_cpl[1];
                          echo $bobot_cpmk;?>%</td>
                        <td><?php echo number_format($nilai,2);?></td>
                    </tr>
                    <?php  $no++; }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <!-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <?php
                    if ($amountPage == 0) {
                      //nothing page
                    }elseif ($amountPage == 1) {
                      echo "<li class='page-item'><a class='page-link'>1</a></li>";
                    }else {
                      $prev = $page-1;
                      $next = $page+1;
                      if ($page!=1) {
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=1'>First</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$prev'>&laquo;</a></li>";
                      }
                      for ($i=1; $i <= $amountPage; $i++) {
                        if ($i > $page - 5 and $i < $page + 5) {
                          if ($i != $page) {
                            echo "<li class='page-item'><a class='page-link' href='product.php?page=$i'>$i</a></li>";
                          } else {
                            echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                          }
                        }
                      }
                      if ($page!=$amountPage) {
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$next'>&raquo;</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='product.php?page=$amountPage'>Last</a></li>";
                      }
                    }
                  ?>
                </ul>
              </div> -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
