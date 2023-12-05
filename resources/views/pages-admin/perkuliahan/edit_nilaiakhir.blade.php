<?php
if(isset($_GET['data']) && isset($_GET['id_mahasiswa'])){
	$id_mahasiswa = $_GET['id_mahasiswa'];
	$_SESSION['id_mahasiswa']=$id_mahasiswa;
  $id_kelas_kuliah = $_GET['data'];
	$_SESSION['id_kelas_kuliah']=$id_kelas_kuliah;

	//get data sub_cpmk
	$sql_m = "SELECT SUM() `nilai` FROM `nilaimahasiswa` WHERE `subcpmk_id`='$id_subcpmk' AND `mahasiswa_id` = '$id_mahasiswa' AND `matakuliah_kelasid` = '$id_kelas_kuliah'";
	$query_m = mysqli_query($koneksi,$sql_m);
	while($data_m = mysqli_fetch_row($query_m)){
		$nilai = $data_m[0];
	}
}
?>
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Nilai Akhir</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php?include=nilai-mahasiswa">Nilai Mahasiswa</a></li>
              <li class="breadcrumb-item"><a href="index.php?include=detail-nilai-mahasiswa">Adelia Fitri Kristanti</a></li>
              <li class="breadcrumb-item active">Edit Nilai Akhir</li>
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
                      <?php if($_GET['notif']=="editkosong"){?>
                          <div class="alert alert-danger bg-danger" role="alert">Maaf data <?php echo $_GET['jenis'];?> wajib di isi</div>
                      <?php }?>
                  <?php }?>
                </div>
                <div class="card-header d-flex justify-content-end">
                    <h3 class="card-title col align-self-center">Form Edit Nilai</h3>
                    <!-- <div class="col-sm-2">
                        <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                    </div> -->
                </div>
                <form action="proses-addproduct.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Nilai" value="0">
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="index.php?include=detail-nilai-mahasiswa" class="btn btn-default">Cancel</a>
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

    