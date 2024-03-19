<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KelasKuliah;
use App\Models\MataKuliah;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $semester = Semester::all();
        $activeSemester = $semester->where('is_active', true)->first();
        $query = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
        ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
        ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
        ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
        ->leftJoin('nilaiakhir_mahasiswa', 'matakuliah_kelas.id', '=', 'nilaiakhir_mahasiswa.matakuliah_kelasid')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'nilaiakhir_mahasiswa.mahasiswa_id')
        ->select('nilaiakhir_mahasiswa.nilai_akhir','matakuliah_kelas.*', 'semester.tahun_ajaran', 'semester.semester', 'kelas.nama_kelas as kelas', 'mata_kuliah.nama_matkul as nama_matkul', 'dosen.nama as nama_dosen')
        // ->selectRaw('COUNT(nilaiakhir_mahasiswa.mahasiswa_id) as jumlah_mahasiswa')
        ->where('mahasiswa.id_auth', Auth::user()->id);

        if ($request->has('tahun_ajaran')) {
            $tahunAjaranTerm = $request->input('tahun_ajaran');
            $query->where('semester.id', $tahunAjaranTerm);
            $reqTahunAjaran = $semester->where('id', $tahunAjaranTerm)->first();
            $title = $reqTahunAjaran->tahun_ajaran ." ". $reqTahunAjaran->semester;
        } else {
            // If no semester filter is provided, use the active semester
            $query->where('semester.id', $activeSemester->id ?? null);
            $title = $activeSemester->tahun_ajaran ." ". $activeSemester->semester;
        }
        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('kelas.nama_kelas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mata_kuliah.nama_matkul', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->groupBy('matakuliah_kelas.id');

        $nilai = $query->paginate(5);
        // dd($nilai);
        $startNumber = ($nilai->currentPage() - 1) * $nilai->perPage() + 1;

        return view('pages-mahasiswa.perkuliahan.nilai', [
            'data' => $nilai,
            'semester' => $semester,
            'title' => $title,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Ditemukan');
    }

    public function show() {
        return view('pages-mahasiswa.perkuliahan.detail_nilai');
    }
}

