<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CplFormatExcel;
use App\Http\Controllers\Controller;
use App\Models\Cpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            Cpl::create([
                'kode_cpl' => $request->kode_cpl,
                'deskripsi' => $request->deskripsi,
                'jenis_cpl' => $request->jenis_cpl,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.cpl')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
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
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $cpl = Cpl::find($id);
            $cpl->update([
                'kode_cpl' => $request->kode_cpl,
                'deskripsi' => $request->deskripsi,
                'jenis_cpl' => $request->jenis_cpl,
            ]);

            // return redirect()->route('admin.cpl')->with([
            //     'success' => 'Data Berhasil Diupdate',
            //     'data' => $cpl
            // ]);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate', 'data' => $cpl]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            // return redirect()->route('admin.cpl.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Cpl::where('id', $id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new CplFormatExcel(), 'cpl-excel.xlsx');
    }

    // public function importExcel(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls'
    //     ]);

    //     $file = $request->file('file');


    //     Excel::import(new DosenImportExcel(), $file);

    //     return redirect()->back()->with('success', 'Data imported successfully.');
    // }
}
