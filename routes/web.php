<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Dosen\DosenController;
use App\Http\Controllers\Admin\JenisCplController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\MataKuliahController;
// use App\Http\Controllers\Admin\PenilaianController as AdminPenilaianController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Admin\CplController as AdminCplController;
use App\Http\Controllers\Admin\CpmkController as AdminCpmkController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;

// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\SubCpmkController as AdminSubCpmkController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\PerkuliahanController as AdminPerkuliahanController;
use Illuminate\Support\Facades\View;
// use App\Http\Controllers\DashboardController;
// Route::get('/', [DashboardController::class, 'index']);
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showFormLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth'], function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::prefix('admin/user')->group(function () {
            Route::get('/{id}', [ProfileController::class, 'show'])->name('admin.user');
            Route::get('edit/{id}', [ProfileController::class, 'edit'])->name('admin.user.edit');
            Route::put('edit/{id}', [ProfileController::class, 'update'])->name('user.proses.edit');
        });

        Route::prefix('admin/mahasiswa')->group(function () {
            Route::get('', [AdminMahasiswaController::class, 'index'])->name('admin.mahasiswa');
            Route::get('create', [AdminMahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
            Route::post('create', [AdminMahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
            Route::get('/{id}', [AdminMahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
            Route::get('edit/{id}', [AdminMahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
            Route::put('edit/{id}', [AdminMahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
            Route::delete('{id}', [AdminMahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
        });

        Route::prefix('admin/dosen')->group(function () {
            Route::get('', [AdminDosenController::class, 'index'])->name('admin.dosen');
            Route::get('create', [AdminDosenController::class, 'create'])->name('admin.dosen.create');
            Route::post('create', [AdminDosenController::class, 'store'])->name('admin.dosen.store');
            // Route::get('/{id}', [AdminDosenController::class, 'show'])->name('admin.dosen.show');
            Route::get('edit/{id}', [AdminDosenController::class, 'edit'])->name('admin.dosen.edit');
            Route::put('edit/{id}', [AdminDosenController::class, 'update'])->name('admin.dosen.update');
            Route::delete('{id}', [AdminDosenController::class, 'destroy'])->name('admin.dosen.destroy');
            Route::get('download-excel', [AdminDosenController::class, 'downloadExcel'])->name('admin.dosen.download-excel');
            Route::post('import-excel', [AdminDosenController::class, 'importExcel'])->name('admin.dosen.import-excel');
        });

        Route::prefix('admin/mata-kuliah')->group(function () {
            Route::get('', [MataKuliahController::class, 'index'])->name('admin.matakuliah');
            Route::get('create', [MataKuliahController::class, 'create'])->name('admin.matakuliah.create');
            Route::post('create', [MataKuliahController::class, 'store'])->name('admin.matakuliah.store');
            Route::get('/{id}', [MataKuliahController::class, 'show'])->name('admin.matakuliah.show');
            Route::get('edit/{id}', [MataKuliahController::class, 'edit'])->name('admin.matakuliah.edit');
            Route::put('edit/{id}', [MataKuliahController::class, 'update'])->name('admin.matakuliah.update');
            Route::delete('{id}', [MataKuliahController::class, 'destroy'])->name('admin.matakuliah.destroy');
            Route::get('detail/cpl', [MataKuliahController::class, 'detailCpl']);
            Route::get('detail/cpmk', [MataKuliahController::class, 'detailCpmk']);
            Route::get('detail/sub-cpmk', [MataKuliahController::class, 'detailSubCpmk']);
            Route::get('detail/tugas', [MataKuliahController::class, 'detailTugas']);
        });

        Route::prefix('admin/kelas')->group(function () {
            Route::get('', [KelasController::class, 'index'])->name('admin.kelas');
            Route::get('create', [KelasController::class, 'create'])->name('admin.kelas.create');
            Route::post('create', [KelasController::class, 'store'])->name('admin.kelas.store');
            // Route::get('/{id}', [KelasController::class, 'show'])->name('admin.kelas.show');
            Route::get('edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
            Route::put('edit/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
            Route::delete('{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
        });

        Route::prefix('admin/cpl')->group(function () {
            Route::get('', [AdminCplController::class, 'index'])->name('admin.cpl');
            Route::get('create', [AdminCplController::class, 'create'])->name('admin.cpl.create');
            Route::post('create', [AdminCplController::class, 'store'])->name('admin.cpl.store');
            // Route::get('/{id}', [AdminCplController::class, 'show'])->name('admin.cpl.show');
            Route::get('edit/{id}', [AdminCplController::class, 'edit'])->name('admin.cpl.edit');
            Route::put('edit/{id}', [AdminCplController::class, 'update'])->name('admin.cpl.update');
            Route::delete('{id}', [AdminCplController::class, 'destroy'])->name('admin.cpl.destroy');
        });

        Route::prefix('admin/data-admin')->group(function () {
            Route::get('', [AdminController::class, 'index'])->name('admin.admins');
            Route::get('create', [AdminController::class, 'create'])->name('admin.admins.create');
            Route::post('create', [AdminController::class, 'store'])->name('admin.admins.store');
            // Route::get('/{id}', [adminsController::class, 'show'])->name('admin.admins.show');
            Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.admins.edit');
            Route::put('edit/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
            Route::delete('{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
        });

        Route::prefix('admin/cpmk')->group(function () {
            Route::get('', [AdminCpmkController::class, 'index'])->name('admin.cpmk');
            Route::get('create', [AdminCpmkController::class, 'create'])->name('admin.cpmk.create');
            Route::post('create', [AdminCpmkController::class, 'store'])->name('admin.cpmk.store');
            // Route::get('/{id}', [AdminCpmkController::class, 'show'])->name('admin.cpmk.show');
            Route::get('edit/{id}', [AdminCpmkController::class, 'edit'])->name('admin.cpmk.edit');
            Route::put('edit/{id}', [AdminCpmkController::class, 'update'])->name('admin.cpmk.update');
            Route::delete('{id}', [AdminCpmkController::class, 'destroy'])->name('admin.cpmk.destroy');
        });

        Route::prefix('admin/sub-cpmk')->group(function () {
            Route::get('', [AdminSubCpmkController::class, 'index'])->name('admin.subcpmk');
            Route::get('create', [AdminSubCpmkController::class, 'create'])->name('admin.subcpmk.create');
            Route::post('create', [AdminSubCpmkController::class, 'store'])->name('admin.subcpmk.store');
            // Route::get('/{id}', [AdminSubCpmkController::class, 'show'])->name('admin.subcpmk.show');
            Route::get('edit/{id}', [AdminSubCpmkController::class, 'edit'])->name('admin.subcpmk.edit');
            Route::put('edit/{id}', [AdminSubCpmkController::class, 'update'])->name('admin.subcpmk.update');
            Route::delete('{id}', [AdminSubCpmkController::class, 'destroy'])->name('admin.subcpmk.destroy');
        });

        Route::prefix('admin/kelas-kuliah')->group(function () {
            Route::get('', [AdminPerkuliahanController::class, 'index'])->name('admin.kelaskuliah');
            Route::get('create', [AdminPerkuliahanController::class, 'create'])->name('admin.kelaskuliah.create');
            Route::post('create', [AdminPerkuliahanController::class, 'store'])->name('admin.kelaskuliah.store');
            Route::get('/{id}', [AdminPerkuliahanController::class, 'show'])->name('admin.kelaskuliah.show');
            Route::get('edit/{id}', [AdminPerkuliahanController::class, 'edit'])->name('admin.kelaskuliah.edit');
            Route::put('edit/{id}', [AdminPerkuliahanController::class, 'update'])->name('admin.kelaskuliah.update');
            Route::delete('{id}', [AdminPerkuliahanController::class, 'destroy'])->name('admin.kelaskuliah.destroy');

            Route::get('/{id}/mahasiswa', [AdminPerkuliahanController::class, 'createMahasiswa'])->name('admin.kelaskuliah.createmahasiswa');
            Route::post('/{id}/mahasiswa', [AdminPerkuliahanController::class, 'storeMahasiswa'])->name('admin.kelaskuliah.storemahasiswa');
            Route::delete('{id}/{id_mahasiswa}', [AdminPerkuliahanController::class, 'destroyMahasiswa'])->name('admin.kelaskuliah.destroymahasiswa');
            Route::get('{id}/nilai/{id_mahasiswa}', [AdminNilaiController::class, 'show'])->name('admin.kelaskuliah.nilaimahasiswa');
            Route::get('/nilai/tugas', [AdminNilaiController::class, 'nilaiTugas'])->name('admin.kelaskuliah.nilaitugas');
            Route::get('/nilai/sub-cpmk', [AdminNilaiController::class, 'nilaiSubCpmk'])->name('admin.kelaskuliah.nilaisubcpmk');
            Route::get('/nilai/cpmk', [AdminNilaiController::class, 'nilaiCpmk'])->name('admin.kelaskuliah.nilaicpmk');
            Route::get('/nilai/cpl', [AdminNilaiController::class, 'nilaiCpl'])->name('admin.kelaskuliah.nilaicpl');




            Route::get('{id}/nilai/{id_mahasiswa}/edit/{id_subcpmk}', [AdminNilaiController::class, 'edit'])->name('admin.kelaskuliah.nilaimahasiswa.edit');
            Route::put('{id}/nilai/{id_mahasiswa}/edit/{id_subcpmk}', [AdminNilaiController::class, 'update'])->name('admin.kelaskuliah.nilaimahasiswa.update');
        });

        Route::prefix('admin/semester')->group(function () {
            Route::get('', [SemesterController::class, 'index'])->name('admin.semester');
            Route::get('create', [SemesterController::class, 'create'])->name('admin.semester.create');
            Route::post('store', [SemesterController::class, 'store'])->name('admin.semester.store');
            Route::post('update-active/{id}', [SemesterController::class, 'updateIsActive'])->name('admin.semester.update-active');
            Route::get('edit/{id}', [SemesterController::class, 'edit'])->name('admin.semester.edit');
            Route::post('edit/{id}', [SemesterController::class, 'update'])->name('admin.semester.update');
            Route::delete('{id}', [SemesterController::class, 'destroy'])->name('admin.semester.destroy');
        });
    });


    Route::group(['middleware' => 'role:dosen'], function () {
        Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    });

    Route::group(['middleware' => 'role:mahasiswa'], function () {
        Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    });
});

Route::get('/admin/mata_kuliah/detail_mata_kuliah', function () {
    return View::make('pages-admin.mata_kuliah.detail_mata_kuliah');
});
