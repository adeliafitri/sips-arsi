<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\KelasKuliah;
use App\Models\MataKuliah;
use App\Models\NilaiAkhirMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = NilaiAkhirMahasiswa::join('matakuliah_kelas'. 'nilaiakhir_mahasiswa.matakuliah_kelasid', 'matakuliah_kelas.id')
    //     ->join('kelas', 'matakuliah_kelas.kelas_id', '=', 'kelas.id')
    //     ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
    //     ->join('dosen', 'matakuliah_kelas.dosen_id', '=', 'dosen.id')
    //     ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
    //     ->leftJoin('nilaiakhir_mahasiswa', 'matakuliah_kelas.id', '=', 'nilaiakhir_mahasiswa.matakuliah_kelasid')
    //     ->select('mata_kuliah.id as id_matkul', 'mata_kuliah.kode_matkul', 'mata_kuliah.nama_matkul', 'mata_kuliah.sks')
    //     ->where('mahasiswa.id_auth', Auth::user()->id)
    //     ->distinct();

    //     // Cek apakah ada parameter pencarian
    //     if ($request->has('search')) {
    //         $searchTerm = $request->input('search');
    //         $query->where(function ($query) use ($searchTerm) {
    //             $query->where('kode_matkul', 'like', '%' . $searchTerm . '%')
    //                 ->orWhere('nama_matkul', 'like', '%' . $searchTerm . '%');
    //         });
    //     }

    //     $mata_kuliah = $query->paginate(5);

    //     $startNumber = ($mata_kuliah->currentPage() - 1) * $mata_kuliah->perPage() + 1;

    //     return view('pages-mahasiswa.mata_kuliah.mata_kuliah', [
    //         'data' => $mata_kuliah,
    //         'startNumber' => $startNumber,
    //     ])->with('success', 'Data Mata Kuliah Ditemukan');
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rps = MataKuliah::where('id', $id)->first();

        return view('pages-mahasiswa.mata_kuliah.detail_mata_kuliah', [
            'success' => 'Data Ditemukan',
            'data' => $rps
        ]);
    }

    public function detailCpl(Request $request)
    {
        $id = $request->id;

        $query = Cpmk::where('matakuliah_id', $id)->join('cpl', 'cpl.id', 'cpmk.cpl_id')->select('cpl.*')->distinct();

        $data = $query->paginate(5);

        $startNumber = ($data->currentPage() - 1) * $data->perPage() + 1;

        if ($request->ajax()) {
            return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_cpl', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
            // return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_cpl', compact('data'));
        }

        return response()->json($data);
    }

    public function detailCpmk(Request $request)
    {
        $id = $request->id;

        $query = Cpmk::join('cpl', 'cpl.id', 'cpmk.cpl_id')->where('matakuliah_id', $id)->select('cpmk.*', 'cpl.kode_cpl')->orderBy('cpl.id', 'asc');

        $data = $query->paginate(5);

        $startNumber = ($data->currentPage() - 1) * $data->perPage() + 1;

        if ($request->ajax()) {
            return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_cpmk', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
            // return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_cpmk', compact('data'));
        }

        return response()->json($data);
    }

    public function detailSubCpmk(Request $request)
    {
        $id = $request->id;

        $query = Cpmk::where('matakuliah_id', $id)->join('sub_cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')->select('sub_cpmk.*', 'cpmk.kode_cpmk')->orderBy('cpmk.id');

        $data = $query->paginate(5);

        $startNumber = ($data->currentPage() - 1) * $data->perPage() + 1;

        if ($request->ajax()) {
            return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_subcpmk', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
            // return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_subcpmk', compact('data'));
        }

        return response()->json($data);
    }

    public function detailTugas(Request $request)
    {
        $id = $request->id;

        $query = Cpmk::where('matakuliah_id', $id)->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->join('sub_cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('soal_sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->select('soal_sub_cpmk.*', 'sub_cpmk.kode_subcpmk', 'soal.bentuk_soal', 'cpmk.kode_cpmk', 'cpl.kode_cpl')->orderBy('sub_cpmk.id', 'asc');
        $data = $query->paginate(5);

        $startNumber = ($data->currentPage() - 1) * $data->perPage() + 1;

        if ($request->ajax()) {
            return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_rps', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
            // return view('pages-mahasiswa.mata_kuliah.partials.detail.detail_rps', compact('data'));
        }

        return response()->json($data);
    }
}
