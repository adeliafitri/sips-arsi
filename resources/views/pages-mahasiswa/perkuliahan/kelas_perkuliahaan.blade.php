<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Perkuliahan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="index.php?include=dashboard">Home</a></li> -->
            <li class="breadcrumb-item active">Data Perkuliahan</li>
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
                  <a href="index.php?include=tambah-kelas-perkuliahan" class="btn btn-primary"><i class="nav-icon fas fa-plus mr-2"></i> Tambah Data</a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">No</th>
                    <th>Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Tahun Ajaran</th>
                    <th style="width: 100px;">Semester</th>
                    <!-- <th style="width: 100px;">Jumlah Mahasiswa</th> -->
                    <!-- <th style="width: 150px;">Action</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>1</td>
                      <td>G</td>
                      <td>Desain Arsitektur Islam 1</td>
                      <td>Aisyah, M.Ars</td>
                      <td>2023/2024</td>
                      <td>Genap</td>
                      <!-- <td>15</td> -->
                      <!-- <td>
                          <a href="index.php?include=detail-kelas-perkuliahan" class="btn btn-info"><i class="nav-icon far fa-eye mr-2"></i>Detail</a>
                          <a href="index.php?include=edit-kelas-perkuliahan" class="btn btn-secondary mt-1"><i class="nav-icon fas fa-edit mr-2"></i>Edit</a>
                          <a href="javascript:if(confirm('Anda yakin ingin menghapus data?')) window.location.href = 'index.php?include=data-kelas-perkuliahan&notif=hapusberhasil'" class="btn btn-danger mt-1"><i class="nav-icon fas fa-trash-alt mr-2"></i>Delete</a>
                      </td> -->
                  </tr>
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
