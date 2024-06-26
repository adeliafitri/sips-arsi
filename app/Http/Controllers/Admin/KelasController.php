<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kelas::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('nama_kelas', 'like', '%' . $searchTerm . '%');
            });
        }

        $kelas = $query->paginate(5);

        $startNumber = ($kelas->currentPage() - 1) * $kelas->perPage() + 1;

        return view('pages-admin.kelas.kelas', [
            'data' => $kelas,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Kelas Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.kelas.tambah_kelas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_kelas' => 'required|string',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            Kelas::create([
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->route('admin.kelas')->with('success', 'Data Berhasil Ditambahkan');
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
        $kelas = Kelas::find($id);

        return view('pages-admin.kelas.edit_kelas', [
            'success' => 'Data Ditemukan',
            'data' => $kelas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_kelas' => 'required|string',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $kelas = Kelas::find($id);
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->route('admin.kelas')->with([
                'success' => 'Data Berhasil Diupdate',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.kelas.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Kelas::where('id', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
            // return redirect()->route('admin.kelas')
            //     ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
            // return redirect()->route('admin.kelas')
            //     ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
