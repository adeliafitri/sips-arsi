<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\KelasKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkuliahanController extends Controller
{
    public function index(Request $request)
    {
        $query = KelasKuliah::join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
        ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
        ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
        ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
        ->leftJoin('nilaiakhir_mahasiswa', 'matakuliah_kelas.id', '=', 'nilaiakhir_mahasiswa.matakuliah_kelasid')
        ->select('matakuliah_kelas.*', 'semester.tahun_ajaran', 'semester.semester', 'kelas.nama_kelas as kelas', 'mata_kuliah.nama_matkul as nama_matkul', 'dosen.nama as nama_dosen')
        ->selectRaw('COUNT(nilaiakhir_mahasiswa.mahasiswa_id) as jumlah_mahasiswa')
        ->where('dosen.id_auth', Auth::user()->id);

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('kelas.nama_kelas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mata_kuliah.nama_matkul', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->groupBy('matakuliah_kelas.id');

        $kelas_kuliah = $query->paginate(5);
        // dd($kelas_kuliah);
        $startNumber = ($kelas_kuliah->currentPage() - 1) * $kelas_kuliah->perPage() + 1;

        return view('pages-dosen.perkuliahan.kelas_perkuliahan', [
            'data' => $kelas_kuliah,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Ditemukan');
    }
}
