<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpmk;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\KelasKuliah;
use Illuminate\Http\Request;
use App\Models\NilaiMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Models\NilaiAkhirMahasiswa;
use Illuminate\Support\Facades\Validator;

class PerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->leftJoin('nilaiakhir_mahasiswa', 'matakuliah_kelas.id', '=', 'nilaiakhir_mahasiswa.matakuliah_kelasid')
            ->select('matakuliah_kelas.*', 'semester.tahun_ajaran', 'semester.semester', 'kelas.nama_kelas as kelas', 'mata_kuliah.nama_matkul as nama_matkul', 'dosen.nama as nama_dosen')
            ->selectRaw('COUNT(nilaiakhir_mahasiswa.mahasiswa_id) as jumlah_mahasiswa');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('kelas.nama_kelas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('dosen.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mata_kuliah.nama_matkul', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->groupBy('matakuliah_kelas.id');

        $kelas_kuliah = $query->paginate(5);

        $startNumber = ($kelas_kuliah->currentPage() - 1) * $kelas_kuliah->perPage() + 1;

        return view('pages-admin.perkuliahan.kelas_perkuliahan', [
            'data' => $kelas_kuliah,
            'startNumber' => $startNumber,
        ])->with('success', 'Data CPMK Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::pluck('nama_kelas', 'id');
        $mata_kuliah = MataKuliah::pluck('nama_matkul', 'id');
        $dosen = Dosen::pluck('nama', 'id');
        $semester = Semester::all();
        return view('pages-admin.perkuliahan.tambah_kelas_perkuliahan', compact('kelas', 'mata_kuliah', 'dosen', 'semester'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kelas' => 'required|exists:kelas,id',
            'mata_kuliah' => 'required|exists:mata_kuliah,id',
            'dosen' => 'required|exists:dosen,id',
            'semester' => 'required',
        ]);
        // dd($validate);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $existingRecord = KelasKuliah::where('matakuliah_id', $request->mata_kuliah)
                ->where('dosen_id', $request->dosen)
                ->first();

            $koordinatorValue = $existingRecord ? $existingRecord->koordinator : "0";

            KelasKuliah::create([
                'kelas_id' => $request->kelas,
                'matakuliah_id' => $request->mata_kuliah,
                'dosen_id' => $request->dosen,
                'semester_id' => $request->semester,
                'koordinator' => $koordinatorValue,
            ]);
            // dd($request->semester);
            return redirect()->route('admin.kelaskuliah')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: ' . $e->getMessage()])->withInput();
        }
    }

    public function updateKoordinator(Request $request, int $id)
    {
        try {
            // dd($request->koordinator);
            $kelas_kuliah = KelasKuliah::where('id', $id)->first();

            $oldKoordinatorValue = $kelas_kuliah->koordinator;
            // dd($kelas_kuliah->koordinator);

            $kelas_kuliah->update([
                'koordinator' => $request->koordinator
            ]);
            // dd($query->toSql(), $query->getBindings());

            if ($oldKoordinatorValue != $request->koordinator) {
                $this->updateOtherData($kelas_kuliah->dosen_id, $kelas_kuliah->matakuliah_id, $request->koordinator);
            }

            return response()->json(['status' => 'success', 'message' => 'Data koordinator berhasil diupdate']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data koordinator gagal diupdate: ' . $e->getMessage()], 500);
        }
    }

    private function updateOtherData($dosenID, $matakuliahID, $newKoordinatorValue)
    {
        try {
            KelasKuliah::where('dosen_id', $dosenID)
                ->where('matakuliah_id', $matakuliahID)
                ->update([
                    'koordinator' => $newKoordinatorValue
                ]);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $kelas_kuliah = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->select(
                'matakuliah_kelas.*',
                'semester.tahun_ajaran',
                'semester.semester',
                'kelas.nama_kelas as kelas',
                'mata_kuliah.nama_matkul as nama_matkul',
                'dosen.nama as nama_dosen'
            )
            ->where('matakuliah_kelas.id', $id)->first();

        $jumlah_mahasiswa = NilaiAkhirMahasiswa::selectRaw('COUNT(nilaiakhir_mahasiswa.mahasiswa_id) as jumlah_mahasiswa')->where('nilaiakhir_mahasiswa.matakuliah_kelasid', $id)->first();
        // dd($jumlah_mahasiswa);

        $query = NilaiAkhirMahasiswa::join('mahasiswa', 'nilaiakhir_mahasiswa.mahasiswa_id', '=', 'mahasiswa.id')
            ->select('mahasiswa.*', 'nilaiakhir_mahasiswa.nilai_akhir as nilai_akhir')
            // ->distinct()
            ->where('nilaiakhir_mahasiswa.matakuliah_kelasid', $id);

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('mahasiswa.nim', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mahasiswa.nama', 'like', '%' . $searchTerm . '%');
            });
        }
        // $query->distinct();
        $mahasiswa = $query->distinct()->paginate(5);

        $startNumber = ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + 1;

        $keterangan = [];

        foreach ($mahasiswa as $mhs) {
            $nilai_akhir = $mhs->nilai_akhir;

            if ($nilai_akhir >= 61) {
                $keterangan[$mhs->id] = "Lulus";
            } else {
                $keterangan[$mhs->id] = "Tidak Lulus";
            }
        }

        // dd($keterangan);

        return view('pages-admin.perkuliahan.detail_kelas_perkuliahan', [
            'success' => 'Data Ditemukan',
            'data' => $kelas_kuliah,
            'jumlah_mahasiswa' => $jumlah_mahasiswa,
            'keterangan' => $keterangan,
            'mahasiswa' => $mahasiswa,
            'startNumber' => $startNumber,
        ]);
    }

    public function createMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::pluck('nama', 'id');
        $kelas_kuliah = KelasKuliah::find($id);
        $matakuliah_kelas = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
            ->select('matakuliah_kelas.*', 'kelas.nama_kelas as kelas', 'mata_kuliah.nama_matkul as nama_matkul')
            ->get();

        return view('pages-admin.perkuliahan.tambah_daftar_mahasiswa', compact('kelas_kuliah', 'mahasiswa', 'matakuliah_kelas'));
    }

    public function storeMahasiswa(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'mahasiswa' => 'required|exists:mahasiswa,id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $matkul_id = KelasKuliah::where('id', $id)->value('matakuliah_id');
            // $get_matkul = "SELECT `matakuliah_id` FROM `matakuliah_kelas` WHERE `id`= '$id'";
            // $result = DB::select($get_matkul);

            if (empty($matkul_id)) {
                return redirect()->back()->withErrors(['errors' => 'Invalid matakuliah_kelas ID'])->withInput();
            }

            // $id_matkul = $result[0]->matakuliah_i                                                                                                                                                                     d;

            // Your existing SQL query
            $soal_sub_cpmk = Cpmk::join('sub_cpmk', 'cpmk.id', 'sub_cpmk.cpmk_id')
                ->join('soal_sub_cpmk', 'sub_cpmk.id', 'soal_sub_cpmk.subcpmk_id')
                ->where('cpmk.matakuliah_id', $matkul_id)->select('soal_sub_cpmk.id as soal_id')->get();

            // $sql_get = "SELECT `s`.`id` FROM `sub_cpmk` `s`
            // INNER JOIN `cpmk` `c` ON `s`.`cpmk_id` = `c`.`id`
            // INNER JOIN `mata_kuliah` `m` ON `c`.`matakuliah_id` = `m`.`id`
            // WHERE `m`.`id` = $id_matkul";

            // $results = DB::select($sql_get);
            foreach ($soal_sub_cpmk as $data) {
                // dd($data);
                // $soal_id = $data->soal_id;
                try {
                    NilaiMahasiswa::create([
                        'mahasiswa_id' => $request->mahasiswa,
                        'matakuliah_kelasid' => $id,
                        'soal_id' => $data->soal_id,
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: ' . $e->getMessage()])->withInput();
                }
            }

            NilaiAkhirMahasiswa::create([
                'mahasiswa_id' => $request->mahasiswa,
                'matakuliah_kelasid' => $id,
            ]);

            return redirect()->route('admin.kelaskuliah.show', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas_kuliah = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
            ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
            // ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->select(
                'matakuliah_kelas.*',
                'kelas.nama_kelas as kelas',
                'mata_kuliah.nama_matkul as nama_matkul',
                'dosen.nama as nama_dosen'
            )
            ->where('matakuliah_kelas.id', $id)->first();

        $kelas = Kelas::pluck('nama_kelas', 'id');
        $mata_kuliah = MataKuliah::pluck('nama_matkul', 'id');
        $dosen = Dosen::pluck('nama', 'id');
        $semester = Semester::all();
        return view('pages-admin.perkuliahan.edit_kelas_perkuliahan', [
            'success' => 'Data Ditemukan',
            'data' => $kelas_kuliah,
            'kelas' => $kelas,
            'mata_kuliah' => $mata_kuliah,
            'dosen' => $dosen,
            'semester' => $semester
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'kelas' => 'required|exists:kelas,id',
            'mata_kuliah' => 'required|exists:mata_kuliah,id',
            'dosen' => 'required|exists:dosen,id',
            'semester' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $kelas_kuliah = KelasKuliah::find($id);
            $kelas_kuliah->update([
                'kelas_id' => $request->kelas,
                'matakuliah_id' => $request->mata_kuliah,
                'dosen_id' => $request->dosen,
                'semester_id' => $request->semester,
            ]);

            return redirect()->route('admin.kelaskuliah')->with([
                'success' => 'Data Berhasil Diupdate',
                'data' => $kelas_kuliah
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.kelaskuliah.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            KelasKuliah::where('id', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
            // return redirect()->route('admin.kelaskuliah')
            //     ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
            // return redirect()->route('admin.kelaskuliah')
            //     ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function destroyMahasiswa($id, $id_mahasiswa)
    {
        try {
            NilaiMahasiswa::where('mahasiswa_id', $id_mahasiswa)
                ->where('matakuliah_kelasid', $id)
                ->delete();

            NilaiAkhirMahasiswa::where('mahasiswa_id', $id_mahasiswa)
                ->where('matakuliah_kelasid', $id)
                ->delete();

            return redirect()->route('admin.kelaskuliah')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.kelaskuliah')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
