<?php

namespace App\Http\Controllers\Dosen;

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
        $kode_cpmk = Cpmk::where('matakuliah_id', '=', $id)->pluck('kode_cpmk', 'id');
        $kode_subcpmk = SubCpmk::join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->where('cpmk.matakuliah_id', $id)
            ->pluck('sub_cpmk.kode_subcpmk', 'sub_cpmk.id');
            // dd ($kode_subcpmk);
        $data_cpmk =Cpmk::join('cpl', 'cpmk.cpl_id', 'cpl.id')
        ->where('matakuliah_id', '=', $id)
        ->select('cpmk.kode_cpmk', 'cpl.kode_cpl', 'cpmk.id', 'cpmk.deskripsi')
        ->paginate(5);
        $start_nocpmk = ($data_cpmk->currentPage() - 1) * $data_cpmk->perPage() + 1;
        // $data_subcpmk = SubCpmk::where('cpmk_id', '=', $id)->paginate(5);
        $data_subcpmk = SubCpmk::join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
            ->where('cpmk.matakuliah_id', $id)
            ->select('cpmk.kode_cpmk', 'sub_cpmk.kode_subcpmk', 'sub_cpmk.id', 'sub_cpmk.deskripsi')
            ->paginate(5);
        $start_nosubcpmk = ($data_subcpmk->currentPage() - 1) * $data_subcpmk->perPage() + 1;
        $data_soalsubcpmk = SoalSubCpmk::join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->where('cpmk.matakuliah_id', $id)
            ->select('soal_sub_cpmk.id', 'sub_cpmk.kode_subcpmk', 'soal.bentuk_soal', 'soal_sub_cpmk.bobot_soal', 'soal_sub_cpmk.waktu_pelaksanaan')
            ->paginate(20);
            // dd($data_soalsubcpmk);

        $start_nosoalsubcpmk = ($data_soalsubcpmk->currentPage() - 1) * $data_soalsubcpmk->perPage() + 1;
        // dd($data_cpmk);
        $data_soal = Soal::pluck('bentuk_soal', 'id');

            // Mendapatkan langkah saat ini dari sesi, jika tidak ada maka default ke langkah pertama
    $currentStep = session('currentStep', 0);

    // Menyimpan langkah saat ini ke sesi
    session(['currentStep' => $currentStep]);

        return view('pages-dosen.mata_kuliah.tambah_rps', compact('currentStep','cpl','matkul','kode_cpmk','kode_subcpmk', 'data_cpmk', 'start_nocpmk', 'data_subcpmk', 'start_nosubcpmk', 'data_soalsubcpmk', 'start_nosoalsubcpmk', 'data_soal'));
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



            // return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    public function storesubcpmk(Request $request, $id) {

        try {
            SubCpmk::create([
                'cpmk_id' => $request->pilih_cpmk,
                'kode_subcpmk' => $request->kode_subcpmk,
                'deskripsi' => $request->deskripsi_subcpmk,
            ]);

            // return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
            return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
            // return redirect()->route('admin.rps.storecpmk')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }

    }

    public function storesoal(Request $request, $id) {
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
            // dd($bentukSoal);
            // Membuat dan menyimpan data ke dalam tabel SoalSubCpmk
            // $soalSubCpmkData = $request->except('soal_id');
            SoalSubCpmk::create([
                'subcpmk_id' => $request->pilih_subcpmk,
                'bobot_soal' => $request->bobot,
                'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
                'soal_id' => $soal->id
            ]);


            // Kembalikan respons dengan berhasil
            return redirect()->route('admin.rps.create', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
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
                    ->select('sub_cpmk.*', 'cpmk.id as cpmk_id') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
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

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus','data' => $soalsubcpmk]);
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

            $soalsubcpmk = SoalSubCpmk::where('id', $request->soal_subcpmk_id)->first();

            $soalsubcpmk->update([
                'subcpmk_id' => $request->pilih_subcpmk,
                'soal_id' => $soal->id,
                'bobot_soal' => $request->bobot,
                'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate','data' => $soalsubcpmk]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
        }
    }
}
