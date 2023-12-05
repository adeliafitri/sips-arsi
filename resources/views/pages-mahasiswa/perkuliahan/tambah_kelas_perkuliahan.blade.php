<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Kelas Perkuliahan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?include=data-kelas-perkuliahan">Data Kelas Perkuliahan</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
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
              <!-- <div class="col-12 justify-content-center">
              <?php if((!empty($_GET['notif']))&&(!empty($_GET['jenis']))){?>
                    <?php if($_GET['notif']=="tambahkosong"){?>
                        <div class="alert alert-danger bg-danger" role="alert">Maaf data <?php echo $_GET['jenis'];?> wajib di isi</div>
                    <?php }?>
                <?php }?>
              </div> -->
              <div class="card-header d-flex justify-content-end">
                  <h3 class="card-title col align-self-center">Form Tambah Kelas</h3>
                  <!-- <div class="col-sm-2">
                      <a href="index.php?include=data-mahasiswa" class="btn btn-warning"><i class="nav-icon fas fa-arrow-left mr-2"></i> Kembali</a>
                  </div> -->
              </div>
              <form action="proses-addproduct.php" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                  <div class="form-group">
                      <label for="mata-kuliah">Kelas Mata Kuliah</label>
                          <select class="form-control" id="mata-kuliah" name="mata-kuliah">
                          <option value="">- Pilih Kelas Mata Kuliah -</option>
                          <option value="1">Desain Arsitektur Islam 1 - Aisyah, M.Ars</option>
                          </select>
                  </div>
                  </div>
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

  