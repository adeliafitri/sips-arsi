<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $mata_kuliah = $query->paginate(5);

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

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            MataKuliah::create([
                'kode_matkul' => $request->kode_matkul,
                'nama_matkul' => $request->nama_matkul,
                'sks' => $request->sks,
            ]);

            return redirect()->route('admin.matakuliah')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
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
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $mata_kuliah = MataKuliah::find($id);
            $mata_kuliah->update([
                'kode_matkul' => $request->kode_matkul,
                'nama_matkul' => $request->nama_matkul,
                'sks' => $request->sks,
            ]);

            return redirect()->route('admin.matakuliah')->with([
                'success' => 'Data Berhasil Diupdate',
                'data' => $mata_kuliah
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.matakuliah.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            MataKuliah::where('id', $id)->delete();

            return redirect()->route('admin.matakuliah')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.matakuliah')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
