<?php
if(isset($_GET['data'])){
	$id_kelas_kuliah = $_GET['data'];
	$_SESSION['id_kelas_kuliah']=$id_kelas_kuliah;
	//get data sub_cpmk
	$sql_m = "SELECT `kelas_id`,`matakuliah_id`, `dosen_id`, `tahun_ajaran`, `semester` FROM `matakuliah_kelas` WHERE `id`='$id_kelas_kuliah'";
	$query_m = mysqli_query($koneksi,$sql_m);
	while($data_m = mysqli_fetch_row($query_m)){
		$kelas_id = $data_m[0];
		$matakuliah_id= $data_m[1];
    $dosen_id = $data_m[2];
    $tahun_ajaran = $data_m[3];
    $semester = $data_m[4];
	}
}
?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Kelas Perkuliahan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?include=data-kelas-perkuliahan">Data Kelas Perkuliahan</a></li>
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
                <?php if((!empty($_GET['notif']))&&(!empty($_GET['jenis']))){?>
                      <?php if($_GET['notif']=="tambahkosong"){?>
                          <div class="alert alert-danger bg-danger" role="alert">Maaf data <?php echo $_GET['jenis'];?> wajib di isi</div>
                      <?php }?>
                  <?php }?>
                </div>
              <div class="card-header d-flex justify-content-end">
                <h3 class="card-title col align-self-center">Form Edit Data Kelas Perkuliahan</h3>
                <!-- <div class="col-sm-2">
                    <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                </div> -->
              </div>
                <div class="card-body">
                <form action="index.php?include=proses-edit-kelas-kuliah" method="post">
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                        <select class="form-control select2bs4" id="kelas" name="kelas">
                        <option value="">- Pilih Kelas-</option>
                        <?php
                        $sql_k = "SELECT `id`, `nama_kelas` FROM `kelas` ORDER BY `nama_kelas`";
                        $query_k = mysqli_query($koneksi, $sql_k);
                        while($data_k = mysqli_fetch_row($query_k)){
                                $id_kelas = $data_k[0];
                                $nama_kelas = $data_k[1];
                        ?>
                        <option value="<?php echo $id_kelas;?>" <?php if($id_kelas==$kelas_id){?>
                        selected <?php }?>><?php echo "$nama_kelas";?></option>
                        <?php }?>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="mata_kuliah">Mata Kuliah</label>
                        <select class="form-control select2bs4" id="mata_kuliah" name="mata_kuliah">
                        <option value="">- Pilih Mata Kuliah-</option>
                        <?php
                        $sql_k = "SELECT `id`, `nama_matkul` FROM `matakuliah` ORDER BY `nama_matkul`";
                        $query_k = mysqli_query($koneksi, $sql_k);
                        while($data_k = mysqli_fetch_row($query_k)){
                                $id_matkul = $data_k[0];
                                $nama_matkul = $data_k[1];
                        ?>
                        <option value="<?php echo $id_matkul;?>" <?php if($id_matkul==$matakuliah_id){?>
                        selected <?php }?>><?php echo "$nama_matkul";?></option>
                        <?php }?>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="dosen">Dosen</label>
                        <select class="form-control select2bs4" id="dosen" name="dosen">
                        <option value="">- Pilih Dosen-</option>
                        <?php
                        $sql_k = "SELECT `id`, `nama` FROM `dosen` ORDER BY `nama`";
                        $query_k = mysqli_query($koneksi, $sql_k);
                        while($data_k = mysqli_fetch_row($query_k)){
                                $id_dosen = $data_k[0];
                                $nama_dosen = $data_k[1];
                        ?>
                        <option value="<?php echo $id_dosen;?>" <?php if($id_dosen==$dosen_id){?>
                        selected <?php }?>><?php echo "$nama_dosen";?></option>
                        <?php }?>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Tahun Ajaran" value="<?php echo "$tahun_ajaran";?>">
                  </div>
                  <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" id="semester" name="semester" placeholder="Semester" value="<?php echo "$semester";?>">
                  </div>
                 <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="index.php?include=data-kelas-perkuliahan" class="btn btn-default">Cancel</a>
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
