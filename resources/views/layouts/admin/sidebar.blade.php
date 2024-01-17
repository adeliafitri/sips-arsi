<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./pages/dashboard.php" class="brand-link">
        <img src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" alt="Logo Prodi Arsitektur UIN Malang" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">Prodi Arsitektur</span>
    </a>

    @php
    $user = session('admin') ?? session('dosen') ?? session('mahasiswa');
    // dd(session()->all());
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            @if (session()->has('admin'))
                @php
                $images = $admin->image;
                @endphp
            <img src="{{ asset('storage/image/' . $images) }}" class="img-circle elevation-2" alt="User Image">
            @elseif (session()->has('dosen'))
                @php
                    $images = $dosen->image;
                @endphp
            <img src="{{ asset('storage/image/' . $images) }}" class="img-circle elevation-2" alt="User Image">
            @elseif (session()->has('mahasiswa'))
                @php
                    $images = $mahasiswa->image;
                @endphp
            <img src="{{ asset('storage/image/' . $images) }}" class="img-circle elevation-2" alt="User Image">
            @endif
            </div>
            <div class="info">
            @if (session()->has('admin'))
            <a href="#" class="d-block">{{ $admin->nama }}</a>
            @elseif (session()->has('dosen'))
            <a href="#" class="d-block">{{ $dosen->nama }}</a>
            @elseif (session()->has('mahasiswa'))
            <a href="#" class="d-block">{{ $mahasiswa->nama }}</a>
            @else
                <p>Welcome, Guest!</p>
                <!-- Atau tampilkan pesan lain jika data admin tidak ditemukan -->
            @endif
            </div>
        </div> --}}
        {{-- @if (session()->has('admin')) --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    $user = session('admin');
                    $image = $user->image;
                @endphp
                    <img src="{{ asset('storage/image/' . $image) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                    <a href="{{ route('admin.user', $user->id_auth) }}" class="d-block">{{ $user->nama }}</a>
            </div>
        </div>
        {{-- @endif --}}

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
                @if (session()->has('admin'))
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                @elseif (session()->has('dosen'))
                <a href="{{ route('dosen.dashboard') }}" class="nav-link active">
                @elseif (session()->has('mahasiswa'))
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link active">
                @endif
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Dashboard
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </a>
            </li>
            @if (session()->has('admin'))
            <li class="nav-item">
                <a href="{{ route('admin.mahasiswa') }}" class="nav-link">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Data Mahasiswa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dosen') }}" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Data Dosen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.matakuliah') }}" class="nav-link">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Data RPS</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.kelaskuliah') }}" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                    Data Kelas Perkuliahan
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Data Master
                    <i class="fas fa-angle-left right"></i>
                    <!-- <span class="badge badge-info right">6</span> -->
                </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.semester') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Semester</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kelas') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Kelas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cpl') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data CPL</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.admins') }}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Data Admin
                </p>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-start"></i>
                        <p class="text-start">
                            Logout
                        </p>
                    </button>
                </form>
            </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
