<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KelasKuliah;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use App\Models\Semester;
use App\Services\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function dashboard(Request $request) {
        $mahasiswa = Mahasiswa::select('angkatan')->distinct()->orderBy('angkatan')->get();
        $getSemesterAktif = Semester::where('is_active', '1')->first();
        $semesters = Semester::all();
        $mata_kuliah = MataKuliah::all();

        // Ambil nilai matkul_id dari request
        $matkulId = $request->input('matkul_id');

        // Query kelas_kuliah dengan filter matkul_id jika ada
        $kelas_kuliah = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
            ->join('rps', 'matakuliah_kelas.rps_id', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->leftJoin('nilaiakhir_mahasiswa', 'matakuliah_kelas.id', '=', 'nilaiakhir_mahasiswa.matakuliah_kelasid')
            ->select(
                'rps.id as id_rps', 'matakuliah_kelas.id as id_kelas', 'mata_kuliah.id as id_matkul',
                'mata_kuliah.nama_matkul as nama_matkul', 'mata_kuliah.kode_matkul', 'semester.tahun_ajaran',
                'semester.semester', 'kelas.nama_kelas'
            )
            ->where('dosen.id_auth', Auth::user()->id)
            ->where('semester.is_active', '1');

        // Tambahkan filter jika matkul_id ada
        if ($matkulId) {
            $kelas_kuliah = $kelas_kuliah->where('mata_kuliah.id', $matkulId);
        }else{
            $kelas_kuliah = $kelas_kuliah->where('mata_kuliah.id', 1);
        }

        $kelas_kuliah = $kelas_kuliah->distinct()
            ->orderBy('mata_kuliah.id', 'asc')
            ->get();

        $dosen_id = Dosen::where('id_auth', Auth::user()->id)->first()->id;
        // dd($dosen_id);

        // List tahun ajaran untuk dropdown
        $listTahun = Semester::select('tahun_ajaran')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        $tahun = $request->tahun_akademik ?? $getSemesterAktif->tahun_ajaran;
        $semester = $request->semester ?? $getSemesterAktif->semester;

        $dataSurvey = $this->surveyService->getSurveyData($dosen_id, $tahun, $semester);
        // dd($dataSurvey, auth()->id());

        return view('pages-dosen.dashboard', [
            'data' => $kelas_kuliah,
            'semester' => $getSemesterAktif,
            'mahasiswa' => $mahasiswa,
            'semesters' => $semesters,
            'mataKuliah' => $mata_kuliah,
            'selectedMatkul' => $matkulId,
            'ikm_total'      => $dataSurvey['ikm_total'],
            'perPertanyaan'  => $dataSurvey['per_pertanyaan'],
            'ikd_total'      => $dataSurvey['ikd_total'],
            'ikd_pertanyaan' => $dataSurvey['ikd_pertanyaan'],
            'listTahun' => $listTahun,
            'tahun' => $tahun,
            'semesterSelected' => ucfirst($semester),
        ]);
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

    // public function chartCplSmtDashboard(Request $request)
    // {
    //     // Ambil semester yang dipilih dari request, jika tidak ada gunakan semester aktif
    //     $semesterId = $request->input('semester_id', null);

    //     if ($semesterId) {
    //         // Jika semester dipilih melalui filter
    //         $selectedSemester = Semester::find($semesterId);
    //     } else {
    //         // Jika tidak ada semester yang dipilih, gunakan semester aktif
    //         $selectedSemester = Semester::where('is_active', '1')->first();
    //     }
    //     $query = NilaiMahasiswa::join('mahasiswa', 'nilai_mahasiswa.mahasiswa_id', 'mahasiswa.id')
    //         ->join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
    //         ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
    //         ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
    //         ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
    //         ->join('rps', 'cpmk.rps_id', 'rps.id')
    //         ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', 'matakuliah_kelas.id')
    //         ->join('semester', 'matakuliah_kelas.semester_id', 'semester.id')
    //         ->join('mata_kuliah', 'rps.matakuliah_id', 'mata_kuliah.id')
    //         ->selectRaw('cpl.kode_cpl, ROUND(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal), 1) as rata_rata_cpl')
    //         ->groupBy('cpl.id','mata_kuliah.id')
    //         ->where('semester.id', $selectedSemester->id);

    //     // $sql = $query->toSql();

    //     $averageCPL = $query->get();

    //     $results = $averageCPL->groupBy('kode_cpl')->map(function ($group) {
    //         return $group->avg('rata_rata_cpl');
    //     });

    //     $labels = $results->keys()->toArray(); // Ambil kode CPL sebagai label
    //     $values = $results->values()->toArray();

    //     return response()->json([
    //         'labels' => $labels,
    //         'values' => $values,
    //     ]);
    // }
}
