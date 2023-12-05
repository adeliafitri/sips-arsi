<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./pages/dashboard.php" class="brand-link">
        <img src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" alt="Logo Prodi Arsitektur UIN Malang" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">Prodi Arsitektur</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="./assets-admin/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">Admin</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="index.php?include=dashboard" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Dashboard
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Data Master
                    <i class="fas fa-angle-left right"></i>
                    <!-- <span class="badge badge-info right">6</span> -->
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="index.php?include=data-mahasiswa" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-dosen" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Dosen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-mata-kuliah" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Mata Kuliah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-kelas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Kelas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-jenis-cpl" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Jenis CPL</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-cpl" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data CPL</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-cpmk" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data CPMK</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?include=data-sub-cpmk" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Sub-CPMK</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="index.php?include=data-kelas-perkuliahan" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                    Data Kelas Perkuliahan
                    <!-- <i class="right fas fa-angle-left"></i> -->
                </p>
                </a>
                <!-- <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Kelas Perkuliahan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Pendaftaran Mata Kuliah</p>
                    </a>
                </li>
                </ul> -->
            </li>
            <li class="nav-item">
                <a href="index.php?include=nilai-mahasiswa" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Data Penilaian Mahasiswa
                    <!-- <i class="right fas fa-angle-left"></i> -->
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>

                <p>
                    User
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/UI/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengaturan User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/icons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ubah Password</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                    Logout
                </p>
                </a>
            </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
