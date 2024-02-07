<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CplController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cpl::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('cpl.kode_cpl', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cpl.jenis_cpl', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cpl.deskripsi', 'like', '%' . $searchTerm . '%');
            });
        }

        $cpl = $query->paginate(5);

        $startNumber = ($cpl->currentPage() - 1) * $cpl->perPage() + 1;

        return view('pages-admin.cpl.cpl', [
            'data' => $cpl,
            'startNumber' => $startNumber,
        ])->with('success', 'Data cpl Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.cpl.tambah_cpl');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kode_cpl' => 'required|string',
            'deskripsi' => 'required',
            'jenis_cpl' => 'required',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            Cpl::create([
                'kode_cpl' => $request->kode_cpl,
                'deskripsi' => $request->deskripsi,
                'jenis_cpl' => $request->jenis_cpl,
            ]);

            return redirect()->route('admin.cpl')->with('success', 'Data Berhasil Ditambahkan');
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
        $cpl = Cpl::find($id);

        return view('pages-admin.cpl.edit_cpl', [
            'success' => 'Data Ditemukan',
            'data' => $cpl,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'kode_cpl' => 'required|string',
            'deskripsi' => 'required',
            'jenis_cpl' => 'required',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $cpl = Cpl::find($id);
            $cpl->update([
                'kode_cpl' => $request->kode_cpl,
                'deskripsi' => $request->deskripsi,
                'jenis_cpl' => $request->jenis_cpl,
            ]);

            return redirect()->route('admin.cpl')->with([
                'success' => 'Data Berhasil Diupdate',
                'data' => $cpl
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.cpl.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Cpl::where('id', $id)->delete();

            return redirect()->route('admin.cpl')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.cpl')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
