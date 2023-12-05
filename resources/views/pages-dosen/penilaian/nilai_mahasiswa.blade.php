<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Nilai Mahasiswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="index.php?include=data-mahasiswa">Data Mahasiswa</a></li> -->
            <li class="breadcrumb-item active">Data Nilai Mahasiswa</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <!-- Main content -->
  <?php
    $sql = "SELECT `id`, `nama_matkul` FROM `matakuliah`";
    $result = mysqli_query($koneksi, $sql);
    while($data = mysqli_fetch_row($result)){
      $id_matkul = $data[0];
      $nama_matkul = $data[1];
    ?>
  <section class="content">
    <!-- Default box -->
    <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $nama_matkul;?></h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-plus"></i>
          </button>
          <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button> -->
        </div>
      </div>
      <div class="card-body">
          <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
              <!-- Tautan Tab -->
              <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <?php
                  $sql_kelas = "SELECT `k`.`nama_kelas` FROM `matakuliah_kelas` `mk` INNER JOIN `kelas` `k` ON `mk`.`kelas_id` = `k`.`id` where `mk`.`matakuliah_id` = '$id_matkul'";
                  $result_kelas = mysqli_query($koneksi, $sql_kelas);
                  $firstTab = true; // Untuk menandai tab pertama
                  while($data_kelas = mysqli_fetch_row($result_kelas)){
                      $nama_kelas = $data_kelas[0];
                      $tab_id = 'custom-tabs-three-' . str_replace(' ', '_', $nama_kelas);
                      $tab_classes = $firstTab ? 'nav-link active' : 'nav-link';
                  ?>
                  <li class="nav-item">
                      <a class="<?php echo $tab_classes; ?>" id="<?php echo $tab_id; ?>-tab" data-toggle="pill" href="#<?php echo $tab_id; ?>" role="tab" aria-controls="<?php echo $tab_id; ?>" aria-selected="true">Kelas <?php echo $nama_kelas; ?></a>
                  </li>
                  <?php
                      $firstTab = false; // Setel ke false setelah tab pertama
                  }
                  ?>
              </ul>
            </div>
            <div class="card-body">
              <!-- Tab Panes -->
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <?php
                $sql_kelas = "SELECT `k`.`nama_kelas`, `d`.`nama`, `mk`.`id` FROM `matakuliah_kelas` `mk` INNER JOIN `kelas` `k` ON `mk`.`kelas_id` = `k`.`id` INNER JOIN `dosen` `d` ON `mk`.`dosen_id` = `d`.`id` where `mk`.`matakuliah_id` = '$id_matkul'";
                $result_kelas = mysqli_query($koneksi, $sql_kelas);
                $firstTab = true; // Untuk menandai tab pertama
                while($data_kelas = mysqli_fetch_row($result_kelas)){
                    $nama_kelas = $data_kelas[0];
                    $nama_dosen = $data_kelas[1];
                    $id_kelas_kuliah = $data_kelas[2];
                    $tab_id = 'custom-tabs-three-' . str_replace(' ', '_', $nama_kelas);
                    $pane_classes = $firstTab ? 'tab-pane fade show active' : 'tab-pane fade';
                ?>
                <div class="<?php echo $pane_classes; ?>" id="<?php echo $tab_id; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_id; ?>-tab">
                <p><span class="text-bold">Dosen :</span> <?php echo $nama_dosen?></p>
                  <p><span class="text-bold">Jumlah Mahasiswa(Aktif) :</span> 15</p>
                  <div class="card">
                      <div class="card-header">
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
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                  <th style="width: 10px">No</th>
                                  <th>NIM</th>
                                  <th>Nama Mahasiswa</th>
                                  <th>Nilai Akhir</th>
                                  <th>Keterangan</th>
                                  <th>Action</th>
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
                                      <td>90 (A)</td>
                                      <td>Lulus</td>
                                      <td>
                                          <a href="index.php?include=detail-nilai-mahasiswa&data=<?php echo $id_kelas_kuliah;?>&id_mahasiswa=<?php echo $id_mahasiswa;?>" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a>
                                          <!-- <a href="index.php?include=edit-daftar-mahasiswa" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a> -->
                                          <!-- <a href="javascript:if(confirm('Anda yakin ingin menghapus data?')) window.location.href = 'index.php?include=detail-kelas-perkuliahan&notif=hapusberhasil'" class="btn btn-danger mt-1"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</a> -->
                                      </td>
                                  </tr>
                                <?php  $no++; }?>
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
                                  echo "<li class='page-item'><a class='page-link' href='index.php?include=data-nilai-mahasiswa&halaman=1'>First</a></li>";
                                  echo "<li class='page-item'><a class='page-link' href='index.php?include=data-nilai-mahasiswa&halaman=$prev'>&laquo;</a></li>";
                              }
                              for ($i=1; $i <= $jum_halaman; $i++) {
                                  if ($i > $halaman - 5 and $i < $halaman + 5) {
                                  if ($i != $halaman) {
                                      echo "<li class='page-item'><a class='page-link' href='index.php?include=data-nilai-mahasiswa&halaman=$i'>$i</a></li>";
                                  } else {
                                      echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                                  }
                                  }
                              }
                              if ($halaman!=$jum_halaman) {
                                  echo "<li class='page-item'><a class='page-link' href='index.php?include=data-nilai-mahasiswa&halaman=$next'>&raquo;</a></li>";
                                  echo "<li class='page-item'><a class='page-link' href='index.php?include=data-nilai-mahasiswa&halaman=$jum_halaman'>Last</a></li>";
                              }
                              }
                          ?>
                          </ul>
                      </div>
                  </div>

                  <h5 class="text-bold text-center mb-3">Nilai Rata-Rata Kelas</h5>
                  <div class="row m-3">
                      <div class="col-6">
                          <p class="text-muted m-0">Berdasarkan Tugas</p>
                          <p class="mb-0"><span class="text-bold">Survey & Measured Drawing: </span> 88.07</p>
                          <p class="mb-0"><span class="text-bold">Studi Preseden: </span> 85</p>
                      </div>
                      <div class="col-3">
                          <div class="box box-primary">
                              <!-- <div class="box-header with-border">
                                  <h6 class="box-title">Berdasarkan Tugas</h6>
                              </div> -->
                              <div class="box-body">
                                  <canvas id="radarChart" style="height: 100px; width:100px;"></canvas>
                              </div>
                          </div>
                          <div class="text-center">
                              <button id="downloadButton" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Unduh</button>
                          </div>
                      </div>
                      <!--
                      <div class="col-3">
                          <p class="text-muted m-0">Berdasarkan CPMK</p>
                          <p class="mb-0"><span class="text-bold">CPMK1: </span> 88.07</p>
                          <p class="mb-0"><span class="text-bold">CPMK2: </span> 85</p>
                      </div>
                      <div class="col-2">
                          <p class="text-muted m-0">Berdasarkan CPL</p>
                          <p class="mb-0"><span class="text-bold">CPL1: </span> 88.07</p>
                          <p class="mb-0"><span class="text-bold">CPL2: </span> 85</p>
                      </div> -->
                  </div>
                  <div class="row m-3">
                      <div class="col-6">
                          <p class="text-muted m-0">Berdasarkan Sub-CPMK</p>
                          <p class="mb-0"><span class="text-bold">Sub-CPMK1: </span> 88.07</p>
                          <p class="mb-0"><span class="text-bold">Sub-CPMK2: </span> 85</p>
                      </div>
                      <div class="col-3">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                  <h6 class="box-title">Berdasarkan Sub-CPMK</h6>
                              </div>
                              <div class="box-body">
                                  <canvas id="radarChartSub" style="height: 100px; width:100px;"></canvas>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- <div class="row">


                      <div class="col m-1">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                  <h6 class="box-title">Berdasarkan CPMK</h6>
                              </div>
                              <div class="box-body">
                                  <canvas id="radarChartCPMK" style="height: 100px; width:100px;"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="col m-1">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                  <h6 class="box-title">Berdasarkan CPL</h6>
                              </div>
                              <div class="box-body">
                                  <canvas id="radarChartCPL" style="height: 100px; width:100px;"></canvas>
                              </div>
                          </div>
                      </div>
                  </div> -->
                </div>
                <?php
                    $firstTab = false; // Setel ke false setelah tab pertama
                }
                ?>
            </div>
            <!-- /.card -->
          </div>
      </div>

    </div>

    <!-- /.card -->

  </section>
  <?php }?>
  <!-- /.content -->
  <!-- <div class="$pane_classes" id="custom-tabs-three-<?php echo $nama_kelas?>" role="tabpanel" aria-labelledby="custom-tabs-three-<?php echo $nama_kelas?>-tab"> -->
                  <!-- <p><span class="text-bold">Semester :</span> Genap</p>
                  <p><span class="text-bold">Tahun Ajaran :</span> 2023/2024</p> -->

                <!-- </div> -->
