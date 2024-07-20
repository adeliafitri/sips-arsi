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
use Illuminate\Support\Collection;

class RpsController extends Controller
{

    // public function index()
    // {

    //     // return $data_matkul;
    //     return view('pages-admin.mata_kuliah.tambah_rps')->with('data', $data_cpmk);
    // }

    public function create($id)
    {
        $matkul= MataKuliah::find($id);
        $cpl= Cpl::pluck('kode_cpl', 'id');
        $kode_cpmk = Cpmk::where('matakuliah_id', '=', $id)->pluck('kode_cpmk', 'id');
        $kode_subcpmk = SubCpmk::join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->where('cpmk.matakuliah_id', $id)
            ->pluck('sub_cpmk.kode_subcpmk', 'sub_cpmk.id');
            // dd ($kode_subcpmk);
        // $data_subcpmk = SubCpmk::where('cpmk_id', '=', $id)->paginate(5);
        // dd($data_cpmk);
        $data_soal = Soal::pluck('bentuk_soal', 'id');
        return view('pages-admin.mata_kuliah.tambah_rps', compact('cpl','matkul','kode_cpmk','kode_subcpmk', 'data_soal'));
    }

    public function storecpmk(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'cpl_id' => 'required|exists:cpl,id',
            'kode_cpmk' => 'required|string',
            'deskripsi_cpmk' => 'required|string',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $id_matkul = $id;
            Cpmk::create([
                'matakuliah_id' => $id_matkul,
                'cpl_id' => $request->cpl_id,
                'kode_cpmk' => $request->kode_cpmk,
                'deskripsi' => $request->deskripsi_cpmk,
            ]);

            // return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $e->getMessage()], 500);
        }
    }

    public function storesubcpmk(Request $request, $id) {
        $validate = Validator::make($request->all(), [
            'pilih_cpmk' => 'required|exists:cpmk,id',
            'kode_subcpmk' => 'required|string',
            'deskripsi_subcpmk' => 'required|string',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            SubCpmk::create([
                'cpmk_id' => $request->pilih_cpmk,
                'kode_subcpmk' => $request->kode_subcpmk,
                'deskripsi' => $request->deskripsi_subcpmk,
            ]);

            // return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $e->getMessage()], 500);
            // return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }

    }

    public function listSubCpmk($id) {
        $data['data_subcpmk'] = SubCpmk::join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->where('cpmk.matakuliah_id', $id)
            ->select('cpl.kode_cpl', 'cpmk.kode_cpmk', 'sub_cpmk.kode_subcpmk', 'sub_cpmk.id', 'sub_cpmk.deskripsi')
            ->paginate(5);
        $data['start_nosubcpmk'] = ($data['data_subcpmk']->currentPage() - 1) * $data['data_subcpmk']->perPage() + 1;


        return view('pages-admin.mata_kuliah.partials.tabel_rps.tabel_subcpmk', $data);
    }

    public function listCpmk($id) {
        $data['data_cpmk'] =Cpmk::join('cpl', 'cpmk.cpl_id', 'cpl.id')
        ->where('matakuliah_id', '=', $id)
        ->select('cpmk.kode_cpmk', 'cpl.kode_cpl', 'cpmk.id', 'cpmk.deskripsi')
        ->paginate(2);
        $data['start_nocpmk'] = ($data['data_cpmk']->currentPage() - 1) * $data['data_cpmk']->perPage() + 1;

        return view('pages-admin.mata_kuliah.partials.tabel_rps.tabel_cpmk', $data);
    }

    public function listTugas($id) {
        $data['data_soalsubcpmk'] = SoalSubCpmk::join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->where('cpmk.matakuliah_id', $id)
            ->select('cpl.kode_cpl', 'cpmk.kode_cpmk', 'soal_sub_cpmk.id', 'sub_cpmk.kode_subcpmk', 'soal.bentuk_soal', 'soal_sub_cpmk.bobot_soal', 'soal_sub_cpmk.waktu_pelaksanaan')
            ->paginate(10);
            // ->toSql();
            // dd($data_soalsubcpmk);

        $data['start_nosoalsubcpmk'] = ($data['data_soalsubcpmk']->currentPage() - 1) * $data['data_soalsubcpmk']->perPage() + 1;

        return view('pages-admin.mata_kuliah.partials.tabel_rps.tabel_tugas', $data);
    }

    public function storesoal(Request $request, $id) {
        $validate = Validator::make($request->all(), [
            // 'pilih_subcpmk' => 'required|exists:sub_cpmk,id',
            'pilih_subcpmk' => 'required|array',
            'pilih_subcpmk.*' => 'required|exists:sub_cpmk,id',
            'bobot' => 'required',
            'waktu_pelaksanaan_start' => 'required|numeric|min:1|max:16',
            'waktu_pelaksanaan_end' => 'required|numeric|min:1|max:16',
            // 'waktu_pelaksanaan' => 'required',
            'bentuk_soal' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $bentukSoal = request()->input('bentuk_soal');
            $existingUnit = Soal::where('bentuk_soal', $bentukSoal)->first();
            if (!$existingUnit) {
                $soal = new Soal();
                $soal->bentuk_soal = $bentukSoal;
                $soal->save();
            } else {
                $soal = $existingUnit;
            }

            if ($request->waktu_pelaksanaan_start == $request->waktu_pelaksanaan_end) {
                $minggu = "Minggu " . $request->waktu_pelaksanaan_start;
            } else {
                $minggu = "Minggu " . $request->waktu_pelaksanaan_start . " - " . $request->waktu_pelaksanaan_end;
            }
            // dd($bentukSoal);
            // Membuat dan menyimpan data ke dalam tabel SoalSubCpmk
            // $soalSubCpmkData = $request->except('soal_id');
            foreach ($request->pilih_subcpmk as $subcpmkid) {
                SoalSubCpmk::create([
                    'subcpmk_id' => $subcpmkid,
                    'bobot_soal' => $request->bobot,
                    'waktu_pelaksanaan' => $minggu,
                    'soal_id' => $soal->id
                ]);
            }

            // Kembalikan respons dengan berhasil
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $e->getMessage()], 500);
            // return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    public function destroyCpmk($id)
    {
        try {
            $cpmk = Cpmk::findOrFail($id);
            $cpmk->sub_cpmk()->delete();
            $cpmk->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function destroySubCpmk($id)
    {
        try {
            $subcpmk = SubCpmk::findOrFail($id);

            $subcpmk->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function destroySoal($id)
    {
        try {
            $soal = SoalSubCpmk::findOrFail($id);

            $soal->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function editCpmk($id)
    {
        try{
            $cpmk = Cpmk::join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
                    ->where('cpmk.id', $id)
                    ->select('cpmk.*', 'cpl.id as cpl_id') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus','data' => $cpmk]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function updateCpmk(Request $request)
    {
        try{
            // dd($request->all());
            // Update data produk berdasarkan ID
            $cpmk = Cpmk::where('id', $request->cpmk_id)->first();

            $cpmk->update([
                'cpl_id' => $request->cpl_id,
                'kode_cpmk' => $request->kode_cpmk,
                'deskripsi' => $request->deskripsi_cpmk,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate','data' => $cpmk]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
        }
    }

    public function editSubCpmk($id)
    {
        try{
            $subcpmk = SubCpmk::join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
                    ->where('sub_cpmk.id', $id)
                    ->select('sub_cpmk.*', 'cpmk.id as cpmk_id', 'cpmk.kode_cpmk') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus','data' => $subcpmk]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function updateSubCpmk(Request $request)
    {
        try{
            // Update data produk berdasarkan ID
            $subcpmk = SubCpmk::where('id', $request->subcpmk_id)->first();

            $subcpmk->update([
                'cpmk_id' => $request->pilih_cpmk,
                'kode_subcpmk' => $request->kode_subcpmk,
                'deskripsi' => $request->deskripsi_subcpmk,
            ]);

           return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate','data' => $subcpmk]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
        }
    }

    public function editSoalSubCpmk($id)
    {
        try{
            $soalsubcpmk = SoalSubCpmk::join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
                ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
                ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
                ->where('soal_sub_cpmk.id', $id)
                ->select('sub_cpmk.id as subcpmk_id', 'soal_sub_cpmk.id', 'sub_cpmk.kode_subcpmk', 'soal.bentuk_soal', 'soal_sub_cpmk.bobot_soal', 'soal_sub_cpmk.waktu_pelaksanaan') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                ->first();
            // dd($soalsubcpmk);

            $minggu = $soalsubcpmk->waktu_pelaksanaan;

            // Menggunakan regex untuk menemukan angka
            preg_match_all('/\d+/', $minggu, $matches);

            $angka = collect($matches[0]);

            $waktu_pelaksanaan_start = $angka->first();
            $waktu_pelaksanaan_end = $angka->last();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'data' => $soalsubcpmk,
                'minggu_mulai' => $waktu_pelaksanaan_start,
                'minggu_akhir' => $waktu_pelaksanaan_end,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }

    public function updateSoalSubCpmk(Request $request)
    {
        try{
            $bentukSoal = request()->input('bentuk_soal');
            $existingUnit = Soal::where('bentuk_soal', $bentukSoal)->first();
            if (!$existingUnit) {
                $soal = new Soal();
                $soal->bentuk_soal = $bentukSoal;
                $soal->save();
            } else {
                $soal = $existingUnit;
            }

            if ($request->waktu_pelaksanaan_start == $request->waktu_pelaksanaan_end) {
                $minggu = "Minggu " . $request->waktu_pelaksanaan_start;
            } else {
                $minggu = "Minggu " . $request->waktu_pelaksanaan_start . " - " . $request->waktu_pelaksanaan_end;
            }

            $soalsubcpmk = SoalSubCpmk::where('id', $request->soal_subcpmk_id)->first();

            $soalsubcpmk->update([
                'subcpmk_id' => $request->pilih_subcpmk,
                'soal_id' => $soal->id,
                'bobot_soal' => $request->bobot,
                'waktu_pelaksanaan' => $minggu,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate','data' => $soalsubcpmk]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
        }
    }

}

    /**
     * Update the specified resource in storage.
     */



