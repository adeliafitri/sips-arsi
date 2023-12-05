<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisCpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisCplController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JenisCpl::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('nama_jenis', 'like', '%' . $searchTerm . '%');
            });
        }

        $jenis_cpl = $query->paginate(5);

        $startNumber = ($jenis_cpl->currentPage() - 1) * $jenis_cpl->perPage() + 1;

        return view('pages-admin.jenis_cpl.jenis_cpl', [
            'data' => $jenis_cpl,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Jenis CPL Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.jenis_cpl.tambah_jenis_cpl');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_jenis' => 'required|string',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            JenisCpl::create([
                'nama_jenis' => $request->nama_jenis,
            ]);

            return redirect()->route('admin.jeniscpl')->with('success', 'Data Berhasil Ditambahkan');
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
        $jenis_cpl = JenisCpl::find($id);

        return view('pages-admin.jenis_cpl.edit_jenis_cpl', [
            'success' => 'Data Ditemukan',
            'data' => $jenis_cpl,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_jenis' => 'required|string',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $jenis_cpl = JenisCpl::find($id);
            $jenis_cpl->update([
                'nama_jenis' => $request->nama_jenis,
            ]);

            return redirect()->route('admin.jeniscpl')->with([
                'success' => 'Data Berhasil Diupdate',
                'data' => $jenis_cpl
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.jeniscpl.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            JenisCpl::where('id', $id)->delete();

            return redirect()->route('admin.jeniscpl')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.jeniscpl')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
