<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\KelasKuliah;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $jml_mahasiswa = Mahasiswa::count();
        $jml_dosen = Dosen::count();
        $jml_matkul = MataKuliah::count();
        $jml_kelas = KelasKuliah::count();
        $mahasiswa = Mahasiswa::select('angkatan')->distinct()->orderBy('angkatan')->get();
        $semesters = Semester::all();
        // dd($semester);
        $title = 'Angkatan';
        return view('pages-admin.dashboard', compact('jml_mahasiswa', 'jml_dosen', 'jml_matkul', 'jml_kelas', 'mahasiswa', 'title',  'semesters'));
    }

    public function index(Request $request)
    {
        $query = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
            ->select('admin.*');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('admin.nama', 'like', '%' . $searchTerm . '%');
            });
        }

        $admin = $query->paginate(20);

        $startNumber = ($admin->currentPage() - 1) * $admin->perPage() + 1;

        return view('pages-admin.admin.admins', [
            'data' => $admin,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Admin Ditemukan');
    }

    public function create()
    {
        return view('pages-admin.admin.tambah_admin');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email',
            'telp' => 'required',
        ]);
        // dd($validate);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $password = 'admin123';
            $auth = User::create([
                'username' => $request->email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $id_auth = $auth->id;

            Admin::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'id_auth' => $id_auth
            ]);

            // return redirect()->route('admin.admins')->with('success', 'Data Berhasil Ditambahkan');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
            // return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    public function detailUser()
    {
        return view('pages-admin.admin.detail_user');
    }

    public function edit($id)
    {
        // dd($id);
        $admin = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
            ->where('admin.id', $id)
            ->select('admin.*', 'auth.username') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
            ->first();
        // dd($admin);
        if (!$admin) {
            return redirect()->route('admin.admins')->withErrors(['error' => 'Admin not found']);
        }
        return view('pages-admin.admin.edit_admin', [
            'success' => 'Data Found',
            'data' => $admin,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email',
            'telp' => 'required',
        ]);
        // dd($validate);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            // Update data produk berdasarkan ID
            $admin = Admin::where('id', $id)->first();
            $admin->update([
                'nama' => $request->nama,
                'telp' => $request->telp,
                'email' => $request->email,
            ]);

            // return redirect()->route('admin.admins')->with([
            //     'success' => 'User updated successfully.',
            //     'data' => $admin
            // ]);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate', 'data' => $admin]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
            // return redirect()->route('admin.admins.edit', $id)->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $admin = Admin::where('id_auth', $id)->delete();
            if ($admin) {
                User::where('id', $id)->delete();
                return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $id = $request->id;
        //  dd($id);

        try {
            $admin = Admin::findOrFail($id);
            $auth = User::findOrFail($admin->id_auth);
            $auth->password = Hash::make('admin123');
            $auth->save();

            return response()->json(['status' => 'success', 'message' => 'Berhasil reset password']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal reset password: ' . $e->getMessage()], 500);
        }
    }

    public function chartCplDashboard(Request $request)
    {
        // Ambil tahun sekarang
        $currentYear = date('Y');
        $startYear = $currentYear - 3;

        // Cek jika request mengandung rentang angkatan
        if ($request->has('angkatan_start') && $request->has('angkatan_end')) {
            $startYear = $request->input('angkatan_start');
            $endYear = $request->input('angkatan_end');
        } else {
            // Jika tidak ada filter, gunakan default (tahun sekarang dan 3 tahun ke belakang)
            $endYear = $currentYear;
        }

        $resultsByYear = [];

        // Loop untuk tiap angkatan dalam rentang yang diberikan
        for ($year = $endYear; $year >= $startYear; $year--) {
            $query = NilaiMahasiswa::join('mahasiswa', 'nilai_mahasiswa.mahasiswa_id', 'mahasiswa.id')
                ->join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
                ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
                ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
                ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
                ->join('rps', 'cpmk.rps_id', 'rps.id')
                ->join('mata_kuliah', 'rps.matakuliah_id', 'mata_kuliah.id')
                ->selectRaw('cpl.kode_cpl, ROUND(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal), 1) as rata_rata_cpl')
                ->where('mahasiswa.angkatan', $year)
                ->groupBy('cpl.id','mata_kuliah.id')
                ->orderBy('cpl.id', 'asc');

            $averageCPL = $query->get();

            $results = $averageCPL->groupBy('kode_cpl')->map(function ($group) {
                return $group->avg('rata_rata_cpl');
            });

            $labels = $results->keys()->toArray(); // Ambil kode CPL sebagai label
            $values = $results->values()->toArray();

            $resultsByYear[] = [
                'angkatan' => $year,
                'labels' => $labels,
                'values' => $values
            ];
        }

        return response()->json($resultsByYear);
    }

    public function chartCplSmtDashboard(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $selectedSemester = $semesterId
            ? Semester::find($semesterId)
            : Semester::where('is_active', 1)->first();

        /*
        |--------------------------------------------------------------------------
        | STEP 1 - Nilai CPL per Mahasiswa
        |--------------------------------------------------------------------------
        */

        $mahasiswaCpl = NilaiMahasiswa::join(
                'soal_sub_cpmk',
                'nilai_mahasiswa.soal_id',
                '=',
                'soal_sub_cpmk.id'
            )
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.id', $selectedSemester->id)
            ->selectRaw("
                nilai_mahasiswa.mahasiswa_id,
                mata_kuliah.id as matkul_id,
                mata_kuliah.nama_matkul,
                mata_kuliah.sks,

                cpl.id as cpl_id,
                cpl.kode_cpl,

                ROUND(
                    SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal)
                    /
                    SUM(soal_sub_cpmk.bobot_soal),
                    2
                ) as nilai_cpl_mahasiswa
            ")
            ->groupBy(
                'nilai_mahasiswa.mahasiswa_id',
                'mata_kuliah.id',
                'mata_kuliah.nama_matkul',
                'mata_kuliah.sks',
                'cpl.id',
                'cpl.kode_cpl'
            )
            ->orderBy('cpl.id', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STEP 2 - CPL per Matkul + FIX jumlah mahasiswa
        |--------------------------------------------------------------------------
        */

        $jumlahMahasiswaPerMatkulCpl = NilaiMahasiswa::join(
                'soal_sub_cpmk',
                'nilai_mahasiswa.soal_id',
                '=',
                'soal_sub_cpmk.id'
            )
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.id', $selectedSemester->id)
            ->selectRaw("
                mata_kuliah.id as matkul_id,
                cpl.id as cpl_id,
                COUNT(DISTINCT nilai_mahasiswa.mahasiswa_id) as jumlah_mahasiswa
            ")
            ->groupBy('mata_kuliah.id', 'cpl.id')
            ->get()
            ->keyBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id);

        $matkulCpl = $mahasiswaCpl
            ->groupBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id)
            ->map(function ($group) use ($jumlahMahasiswaPerMatkulCpl) {

                $first = $group->first();

                $key = $first->matkul_id . '-' . $first->cpl_id;

                return [
                    'matkul_id' => $first->matkul_id,
                    'nama_matkul' => $first->nama_matkul,
                    'sks' => $first->sks,
                    'cpl_id' => $first->cpl_id,
                    'kode_cpl' => $first->kode_cpl,

                    'jumlah_mahasiswa' =>
                        $jumlahMahasiswaPerMatkulCpl[$key]->jumlah_mahasiswa ?? 0,

                    'nilai_cpl_matkul' => round(
                        $group->avg('nilai_cpl_mahasiswa'),
                        2
                    ),
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | STEP 3 - Bobot CPL MK
        |--------------------------------------------------------------------------
        */

        $bobotCplMk = DB::table('soal_sub_cpmk')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->selectRaw("
                mata_kuliah.id as matkul_id,
                cpl.id as cpl_id,
                SUM(soal_sub_cpmk.bobot_soal) as bobot_cpl_mk
            ")
            ->groupBy('mata_kuliah.id', 'cpl.id')
            ->get()
            ->keyBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id);

        /*
        |--------------------------------------------------------------------------
        | STEP 4 - FINAL RUMUS CPL SEMESTER
        |--------------------------------------------------------------------------
        */

        $results = $matkulCpl
            ->groupBy('kode_cpl')
            ->map(function ($group) use ($bobotCplMk) {

                $pembilang = 0;
                $penyebut = 0;

                foreach ($group as $item) {

                    $key = $item['matkul_id'] . '-' . $item['cpl_id'];

                    $bobot = $bobotCplMk[$key]->bobot_cpl_mk ?? 0;

                    $jumlahMahasiswa = $item['jumlah_mahasiswa'] ?? 0;

                    $pembilang +=
                        $item['nilai_cpl_matkul']
                        * $item['sks']
                        * $bobot
                        * $jumlahMahasiswa;

                    $penyebut +=
                        $item['sks']
                        * $bobot
                        * $jumlahMahasiswa;
                }

                return $penyebut > 0
                    ? round($pembilang / $penyebut, 2)
                    : 0;
            });

        $labels = $results->keys()->toArray(); // Ambil kode CPL sebagai label
        $values = $results->values()->toArray();

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);

        // return response()->json([
        //     'matkul_cpl' => $matkulCpl,
        //     'cpl_semester' => $results
        // ]);
    }

    public function chartCplSmtMkDashboard(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $selectedSemester = $semesterId
            ? Semester::find($semesterId)
            : Semester::where('is_active', 1)->first();

        $matkulId = $request->input('matkul_id');

        /*
        |--------------------------------------------------------------------------
        | STEP 1 - Nilai CPL per Mahasiswa
        |--------------------------------------------------------------------------
        */

        $mahasiswaCpl = NilaiMahasiswa::join(
                'soal_sub_cpmk',
                'nilai_mahasiswa.soal_id',
                '=',
                'soal_sub_cpmk.id'
            )
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.id', $selectedSemester->id)
            ->when($matkulId, function ($query, $matkulId) {
                return $query->where('mata_kuliah.id', $matkulId);
            })
            ->selectRaw("
                nilai_mahasiswa.mahasiswa_id,
                mata_kuliah.id as matkul_id,
                mata_kuliah.nama_matkul,
                mata_kuliah.sks,

                cpl.id as cpl_id,
                cpl.kode_cpl,

                ROUND(
                    SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal)
                    /
                    SUM(soal_sub_cpmk.bobot_soal),
                    2
                ) as nilai_cpl_mahasiswa
            ")
            ->groupBy(
                'nilai_mahasiswa.mahasiswa_id',
                'mata_kuliah.id',
                'mata_kuliah.nama_matkul',
                'mata_kuliah.sks',
                'cpl.id',
                'cpl.kode_cpl'
            )
            ->orderBy('cpl.id', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STEP 2 - CPL per Matkul + FIX jumlah mahasiswa
        |--------------------------------------------------------------------------
        */

        $jumlahMahasiswaPerMatkulCpl = NilaiMahasiswa::join(
                'soal_sub_cpmk',
                'nilai_mahasiswa.soal_id',
                '=',
                'soal_sub_cpmk.id'
            )
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.id', $selectedSemester->id)
            ->selectRaw("
                mata_kuliah.id as matkul_id,
                cpl.id as cpl_id,
                COUNT(DISTINCT nilai_mahasiswa.mahasiswa_id) as jumlah_mahasiswa
            ")
            ->groupBy('mata_kuliah.id', 'cpl.id')
            ->get()
            ->keyBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id);

        $matkulCpl = $mahasiswaCpl
            ->groupBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id)
            ->map(function ($group) use ($jumlahMahasiswaPerMatkulCpl) {

                $first = $group->first();

                $key = $first->matkul_id . '-' . $first->cpl_id;

                return [
                    'matkul_id' => $first->matkul_id,
                    'nama_matkul' => $first->nama_matkul,
                    'sks' => $first->sks,
                    'cpl_id' => $first->cpl_id,
                    'kode_cpl' => $first->kode_cpl,

                    'jumlah_mahasiswa' =>
                        $jumlahMahasiswaPerMatkulCpl[$key]->jumlah_mahasiswa ?? 0,

                    'nilai_cpl_matkul' => round(
                        $group->avg('nilai_cpl_mahasiswa'),
                        2
                    ),
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | STEP 3 - Bobot CPL MK
        |--------------------------------------------------------------------------
        */

        $bobotCplMk = DB::table('soal_sub_cpmk')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', '=', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
            ->join('rps', 'cpmk.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->selectRaw("
                mata_kuliah.id as matkul_id,
                cpl.id as cpl_id,
                SUM(soal_sub_cpmk.bobot_soal) as bobot_cpl_mk
            ")
            ->groupBy('mata_kuliah.id', 'cpl.id')
            ->get()
            ->keyBy(fn ($item) => $item->matkul_id . '-' . $item->cpl_id);

        /*
        |--------------------------------------------------------------------------
        | STEP 4 - FINAL RUMUS CPL SEMESTER
        |--------------------------------------------------------------------------
        */

        $results = $matkulCpl
            ->groupBy('kode_cpl')
            ->map(function ($group) use ($bobotCplMk) {

                $pembilang = 0;
                $penyebut = 0;

                foreach ($group as $item) {

                    $key = $item['matkul_id'] . '-' . $item['cpl_id'];

                    $bobot = $bobotCplMk[$key]->bobot_cpl_mk ?? 0;

                    $jumlahMahasiswa = $item['jumlah_mahasiswa'] ?? 0;

                    $pembilang +=
                        $item['nilai_cpl_matkul']
                        * $item['sks']
                        * $bobot
                        * $jumlahMahasiswa;

                    $penyebut +=
                        $item['sks']
                        * $bobot
                        * $jumlahMahasiswa;
                }

                return $penyebut > 0
                    ? round($pembilang / $penyebut, 2)
                    : 0;
            });

        $labels = $results->keys()->toArray(); // Ambil kode CPL sebagai label
        $values = $results->values()->toArray();

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);

        // return response()->json([
        //     'matkul_cpl' => $matkulCpl,
        //     'cpl_semester' => $results
        // ]);
    }

    public function getMatkulBySemester(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $matkul = DB::table('matakuliah_kelas')
            ->join('rps', 'matakuliah_kelas.rps_id', '=', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->where('matakuliah_kelas.semester_id', $semesterId)
            ->select('mata_kuliah.id', 'mata_kuliah.nama_matkul')
            ->distinct()
            ->get();

        return response()->json($matkul);
    }
}
