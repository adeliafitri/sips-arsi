<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MataKuliah::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('kode_matkul', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nama_matkul', 'like', '%' . $searchTerm . '%');
            });
        }

        $mata_kuliah = $query->paginate(20);

        $startNumber = ($mata_kuliah->currentPage() - 1) * $mata_kuliah->perPage() + 1;

        return view('pages-admin.mata_kuliah.mata_kuliah', [
            'data' => $mata_kuliah,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Mata Kuliah Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.mata_kuliah.tambah_mata_kuliah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kode_matkul' => 'required|unique:mata_kuliah,kode_matkul',
            'nama_matkul' => 'required|string',
            'sks' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            MataKuliah::create([
                'kode_matkul' => $request->kode_matkul,
                'nama_matkul' => $request->nama_matkul,
                'sks' => $request->sks,
            ]);

            // return redirect()->route('admin.matakuliah')->with('success', 'Data Berhasil Ditambahkan');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $e->getMessage()], 500);
            // return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     $rps = MataKuliah::where('id', $id)->first();

    //     return view('pages-admin.mata_kuliah.detail_mata_kuliah', [
    //         'success' => 'Data Ditemukan',
    //         'data' => $rps
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mata_kuliah = MataKuliah::find($id);

        return view('pages-admin.mata_kuliah.edit_mata_kuliah', [
            'success' => 'Data Ditemukan',
            'data' => $mata_kuliah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'kode_matkul' => 'required',
            'nama_matkul' => 'required|string',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric',
            'tahun_rps' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $mata_kuliah = MataKuliah::find($id);
            $mata_kuliah->update([
                'kode_matkul' => $request->kode_matkul,
                'nama_matkul' => $request->nama_matkul,
                'sks' => $request->sks,
                'semester' => $request->semester,
                'tahun_rps' => $request->tahun_rps
            ]);

            // return redirect()->route('admin.matakuliah')->with([
            //     'success' => 'Data Berhasil Diupdate',
            //     'data' => $mata_kuliah
            // ]);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate', 'data' => $mata_kuliah]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            // return redirect()->route('admin.matakuliah.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            MataKuliah::where('id', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
            // return redirect()->route('admin.matakuliah')
            //     ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
            // return redirect()->route('admin.matakuliah')
            //     ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
