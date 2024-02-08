<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\Soal;
use App\Models\SoalSubCpmk;
use App\Models\SubCpmk;
use Illuminate\Support\Facades\Validator;

class RpsController extends Controller
{
    public function create($id)
    {
        $matkul= MataKuliah::find($id);
        $cpl= Cpl::pluck('kode_cpl', 'id');
        $kode_cpmk = Cpmk::pluck('kode_cpmk', 'id');
        $kode_subcpmk = SubCpmk::pluck('kode_subcpmk', 'id');
        return view('pages-admin.mata_kuliah.tambah_rps', compact('cpl','matkul','kode_cpmk','kode_subcpmk'));

    }

    public function storecpmk(Request $request, $id)
    {
        // $validate = Validator::make($request->all(), [
        //     'kode_matkul' => 'required|unique:mata_kuliah,kode_matkul',
        //     'nama_matkul' => 'required|string',
        //     'sks' => 'required|numeric',
        // ]);

        // if($validate->fails()){
        //     return redirect()->back()->withErrors($validate)->withInput();
        // }


        try {
            $id_matkul = $id;
            Cpmk::create([
                'matakuliah_id' => $id_matkul,
                'cpl_id' => $request->cpl_id,
                'kode_cpmk' => $request->kode_cpmk,
                'deskripsi' => $request->deskripsi_cpmk,
            ]);


            return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    public function storesubcpmk(Request $request) {

        try {
            SubCpmk::create([
                'cpmk_id' => $request->pilih_cpmk,
                'kode_subcpmk' => $request->kode_subcpmk,
                'deskripsi' => $request->deskripsi_subcpmk,
            ]);

            // return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            return redirect()->route('admin.rps.storecpmk')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }

    }

    public function storesoal(Request $request) {
        try {
            SoalSubCpmk::create([
                'subcpmk_id' => $request->pilih_subcpmk,
                'bentuk_soal' => $request->bentuk_soal,
                'bobot_soal' => $request->bobot,
                'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }

    }

}
