<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\NilaiAkhirMahasiswa;
use App\Models\NilaiMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiTugasFormatExcel;
use App\Exports\NilaiAkhirFormatExcel;
use App\Imports\NilaiAkhirImportExcel;
use App\Imports\NilaiTugasImportExcel;

class NilaiController extends Controller
{
    public function show(Request $request, $id, $id_mahasiswa)
    {
        $nilai_mahasiswa = NilaiAkhirMahasiswa::join('mahasiswa', 'nilaiakhir_mahasiswa.mahasiswa_id', '=', 'mahasiswa.id')
            ->join('matakuliah_kelas', 'nilaiakhir_mahasiswa.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', '=', 'mata_kuliah.id')
            ->select('mahasiswa.nama as nama', 'mahasiswa.nim as nim', 'mata_kuliah.nama_matkul as nama_matkul', 'nilaiakhir_mahasiswa.*')
            // ->distinct()
            ->where('nilaiakhir_mahasiswa.matakuliah_kelasid', $id)
            ->where('nilaiakhir_mahasiswa.mahasiswa_id', $id_mahasiswa)
            ->first();
        // dd($nilai_mahasiswa);

        $query = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', '=', 'soal_sub_cpmk.id')
            ->select('soal_sub_cpmk.*', 'nilai_mahasiswa.nilai as nilai')
            // ->distinct()
            ->where('nilai_mahasiswa.matakuliah_kelasid', $id)
            ->where('nilai_mahasiswa.mahasiswa_id', $id_mahasiswa);

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('sub_cpmk.kode_subcpmk', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sub_cpmk.bentuk_soal', 'like', '%' . $searchTerm . '%');
            });
        }
        // $query->distinct();
        $nilai_subcpmk = $query->paginate(20);

        $startNumber = ($nilai_subcpmk->currentPage() - 1) * $nilai_subcpmk->perPage() + 1;

        // $query_sub = NilaiMahasiswa::join('sub_cpmk', 'nilai_mahasiswa.subcpmk_id', '=', 'sub_cpmk.id')
        //     ->join('cpmk', 'sub_cpmk.cpmk_id', '=', 'cpmk.id')
        //     ->join('cpl', 'cpmk.cpl_id', '=', 'cpl.id')
        //     ->select(
        //         'sub_cpmk.kode_subcpmk',
        //         'cpmk.kode_cpmk',
        //         'cpl.kode_cpl',
        //         DB::raw('SUM(sub_cpmk.bobot_subcpmk) as bobot'),
        //         DB::raw('AVG(nilai_mahasiswa.nilai) as nilai')
        //     )
        //     ->where('nilai_mahasiswa.matakuliah_kelasid', $id)
        //     ->where('nilai_mahasiswa.mahasiswa_id', $id_mahasiswa)
        //     ->groupBy('cpl.kode_cpl', 'cpmk.kode_cpmk', 'sub_cpmk.kode_subcpmk')
        //     ->paginate(20);

        // $subNumber = ($query_sub->currentPage() - 1) * $query_sub->perPage() + 1;

        // $sql_cpmk = DB::table('nilai_mahasiswa as n')
        // ->join('sub_cpmk as s', 'n.subcpmk_id', '=', 's.id')
        // ->join('cpmk as ck', 's.cpmk_id', '=', 'ck.id')
        // ->join('cpl as c', 'ck.cpl_id', '=', 'c.id')
        // ->join(DB::raw('(SELECT
        //                     ck.kode_cpmk,
        //                     s.bentuk_soal,
        //                     AVG(CAST(n.nilai AS DECIMAL(10,2))) AS avg_nilai
        //                 FROM
        //                     nilai_mahasiswa n
        //                     INNER JOIN sub_cpmk s ON n.subcpmk_id = s.id
        //                     INNER JOIN cpmk ck ON s.cpmk_id = ck.id
        //                 WHERE
        //                     n.matakuliah_kelasid = ? AND n.mahasiswa_id = ?
        //                 GROUP BY
        //                     ck.kode_cpmk, s.bentuk_soal) as subquery'), function($join) {
        //     $join->on('ck.kode_cpmk', '=', 'subquery.kode_cpmk');
        // })
        // ->select('c.kode_cpl', 'ck.kode_cpmk')
        // ->selectRaw('SUM(s.bobot_subcpmk)/COUNT(DISTINCT s.bentuk_soal) AS bobot')
        // ->selectRaw('AVG(subquery.avg_nilai) AS avg_nilai')
        // ->where('n.matakuliah_kelasid', '=', $id)
        // ->where('n.mahasiswa_id', '=', $id_mahasiswa)
        // ->groupBy('c.kode_cpl', 'ck.kode_cpmk');
        // $result=$sql_cpmk->get(['id'=> $id, 'id_mahasiswa' => $id_mahasiswa]);

        // $cpmkNumber = ($sql_cpmk->currentPage() - 1) * $sql_cpmk->perPage() + 1;
        $query_sub = [];
        $subNumber = [];
        // dd($nilai_mahasiswa);
        return view('pages-dosen.perkuliahan.detail_nilai_mahasiswa', [
            'data' => $nilai_mahasiswa,
            'nilai_subcpmk' => $nilai_subcpmk,
            'startNumber' => $startNumber,
            'sub_cpmk' => $query_sub,
            'subNumber' => $subNumber,
            // 'cpmk' => $result,
            // 'cpmkNumber' => $cpmkNumber
        ]);
    }

    public function nilaiCPL(Request $request)
    {
        $mahasiswa_id = 1;
        $matakuliah_kelasid = 1;
        $data = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal.id', 'soal_sub_cpmk.soal_id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->groupBy('cpl.id')
            ->selectRaw('SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal) as total_nilai, SUM(soal_sub_cpmk.bobot_soal) AS bobot_soal, sub_cpmk.kode_subcpmk, cpmk.kode_cpmk as kode_cpmk, cpl.kode_cpl as kode_cpl')
            // ->selectRaw('SUM(nilai_mahasiswa.nilai) AS nilai, SUM(soal_sub_cpmk.bobot_soal) AS bobot_soal, cpl.kode_cpl as kode_cpl')
            ->orderBy('cpl.id')
            ->where('nilai_mahasiswa.mahasiswa_id', $request->mahasiswa_id)
            ->where('nilai_mahasiswa.matakuliah_kelasid', $request->matakuliah_kelasid)
            ->get();


        $startNumber = [];

        if ($request->ajax()) {
            return view('pages-dosen.perkuliahan.partials.nilai_cpl', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
        }
        return $data;
    }

    public function nilaiSubCpmk(Request $request)
    {
        // $mahasiswa_id = 1;
        // $matakuliah_kelasid = 1;

        $mahasiswa_id = $request->mahasiswa_id;
        $matakuliah_kelasid = $request->matakuliah_kelasid;
        $data = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal.id', 'soal_sub_cpmk.soal_id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->groupBy('soal_sub_cpmk.subcpmk_id')
            ->selectRaw('SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal) as total_nilai, soal_sub_cpmk.bobot_soal AS bobot_soal, sub_cpmk.kode_subcpmk, cpmk.kode_cpmk as kode_cpmk, cpl.kode_cpl as kode_cpl')
            ->orderBy('cpmk.id')
            ->where('nilai_mahasiswa.mahasiswa_id', $request->mahasiswa_id)
            ->where('nilai_mahasiswa.matakuliah_kelasid', $request->matakuliah_kelasid)
            ->get();



        $startNumber = [];

        if ($request->ajax()) {
            return view('pages-dosen.perkuliahan.partials.nilai_sub_cpmk', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
        }
        return $data;
    }

    public function nilaiCpmk(Request $request)
    {
        $mahasiswa_id = 1;
        $matakuliah_kelasid = 1;
        $data = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal.id', 'soal_sub_cpmk.soal_id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->groupBy('cpmk.id')
            ->selectRaw('SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal) as total_nilai, SUM(soal_sub_cpmk.bobot_soal) AS bobot_soal, sub_cpmk.kode_subcpmk, cpmk.kode_cpmk as kode_cpmk, cpl.kode_cpl as kode_cpl')
            // ->selectRaw('SUM(nilai_mahasiswa.nilai) AS nilai, SUM(soal_sub_cpmk.bobot_soal) AS bobot_soal, cpmk.kode_cpmk as kode_cpmk, cpl.kode_cpl as kode_cpl')
            ->orderBy('cpmk.id')
            ->where('nilai_mahasiswa.mahasiswa_id', $request->mahasiswa_id)
            ->where('nilai_mahasiswa.matakuliah_kelasid', $request->matakuliah_kelasid)
            ->get();


        $startNumber = [];

        if ($request->ajax()) {
            return view('pages-dosen.perkuliahan.partials.nilai_cpmk', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
        }
        return $data;
    }

    public function nilaiTugas(Request $request)
    {
        $data = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal.id', 'soal_sub_cpmk.soal_id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->select('soal_sub_cpmk.*', 'soal.bentuk_soal as bentuk_soal', 'nilai_mahasiswa.mahasiswa_id as mahasiswa_id', 'nilai_mahasiswa.matakuliah_kelasid as matakuliah_kelasid', 'nilai_mahasiswa.nilai as nilai', 'nilai_mahasiswa.id as id_nilai', 'sub_cpmk.kode_subcpmk as kode_subcpmk')
            ->where('nilai_mahasiswa.mahasiswa_id', $request->mahasiswa_id)
            ->where('nilai_mahasiswa.matakuliah_kelasid', $request->matakuliah_kelasid)
            ->get();
        $startNumber = [];

        if ($request->ajax()) {
            return view('pages-dosen.perkuliahan.partials.nilai_tugas', [
                'data' => $data,
                'startNumber' => $startNumber,
            ])->with('success', 'Data Mata Kuliah Ditemukan');
        }
        return $data;
    }

    public function editNilaiTugas(Request $request)
    {
        // Retrieve the NilaiMahasiswa entry based on the provided ID
        $data = NilaiMahasiswa::findOrFail($request->id_nilai);

        // Update the nilai field with the value from the request
        $data->nilai = $request->nilai;

        // Save the changes to the database
        $data->save();

        // $this->updateNilaiAkhir($request->mahasiswa_id, $request->matakuliah_kelasid);
        $update_nilai_akhir = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal.id', 'soal_sub_cpmk.soal_id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->where('nilai_mahasiswa.mahasiswa_id', $request->mahasiswa_id)
            ->where('nilai_mahasiswa.matakuliah_kelasid', $request->matakuliah_kelasid)
            ->selectRaw('(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / 100) AS nilai_akhir')
            ->first();

        $data = NilaiAkhirMahasiswa::where('mahasiswa_id', $request->mahasiswa_id)
            ->where('matakuliah_kelasid', $request->matakuliah_kelasid)->first();

        $data->nilai_akhir = $update_nilai_akhir->nilai_akhir;
        $data->save();


        // Redirect the user to a new page with a success message
        return redirect()->back()->with('success', 'Data Nilai Tugas Berhasil Diupdate');
        // return redirect()->route('dosen.kelaskuliah.nilaimahasiswa', ['id' => $id, 'id_mahasiswa' => $id_mahasiswa])->with([
        //     'success' => 'Data Nilai Berhasil Diupdate',
        //     'data' => $nilai_subcpmk
        // ]);
    }

    public function editNilaiAkhir(Request $request)
    {
        $data = NilaiAkhirMahasiswa::findOrFail($request->id_nilai);

        $data->nilai_akhir = $request->nilai_akhir;
        $data->save();

        $nilai_tugas = NilaiMahasiswa::where('mahasiswa_id', $request->mahasiswa_id)->where('matakuliah_kelasid', $request->matakuliah_kelasid)->get();
        foreach ($nilai_tugas as $data) {
            // dd($data);
            $data->nilai = $request->nilai_akhir;
            $data->save();
        }

        return redirect()->back()->with('success', 'Data Nilai Akhir Berhasil Diupdate');
    }

    public function nilaiExcel($id) {
        $nilai_mahasiswa = NilaiMahasiswa::join('mahasiswa', 'nilai_mahasiswa.mahasiswa_id', 'mahasiswa.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', 'matakuliah_kelas.id')
            ->join('mata_kuliah', 'matakuliah_kelas.matakuliah_id', 'mata_kuliah.id')
            ->join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->select('mahasiswa.nim', 'mahasiswa.nama', 'soal_sub_cpmk.id', 'soal_sub_cpmk.waktu_pelaksanaan', 'sub_cpmk.kode_subcpmk', 'soal_sub_cpmk.bobot_soal', 'soal.bentuk_soal','nilai_mahasiswa.id as id_nilai','nilai_mahasiswa.mahasiswa_id as id_mhs', 'nilai_mahasiswa.matakuliah_kelasid as id_kelas', 'nilai_mahasiswa.nilai')
            ->where('matakuliah_kelas.id', $id)
            ->orderby('soal_sub_cpmk.id', 'ASC')
            // ->distinct('soal_sub_cpmk.waktu_pelaksanaan')
            ->get();

            $info_soal = [];
            foreach ($nilai_mahasiswa as $tugas) {
                $info_soal[] = [
                    'waktu_pelaksanaan' => $tugas->waktu_pelaksanaan,
                    'kode_subcpmk' => $tugas->subcpmk,
                    'bobot_soal' => $tugas->bobot,
                    'bentuk_soal' => $tugas->bentuk_soal // Misalnya nama_tugas adalah bentuk_soal
                ];
            }

            $mahasiswa_data = [];
            foreach ($nilai_mahasiswa as $mahasiswa) {
                $nilai_per_tugas = [];
                foreach ($mahasiswa->nilai as $nilai) {
                    $nilai_per_tugas[$nilai->tugas_id] = $nilai->nilai;
                }

                $mahasiswa_data[] = [
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->nama,
                    'nilai_per_tugas' => $nilai_per_tugas
                ];
            }

            return view('pages-dosen.generate.excel.nilai-mahasiswa', compact('mahasiswa_data', 'info_soal'));
    }

    public function downloadExcelNilaiTugas($id)
    {
        return Excel::download(new NilaiTugasFormatExcel($id), 'nilai-tugas-excel.xlsx');
    }

    public function downloadExcelNilaiAkhir($id)
    {
        return Excel::download(new NilaiAkhirFormatExcel($id), 'nilai-akhir-excel.xlsx');
    }

    public function importExcelNilaiAkhir(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');


        Excel::import(new NilaiAkhirImportExcel($id), $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function importExcelNilaiTugas(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');


        Excel::import(new NilaiTugasImportExcel($id), $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function rataRataTugas(Request $request){
        $matakuliah_kelasid = $request->matakuliah_kelasid;
        $nilaiRataRata = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->selectRaw('soal.bentuk_soal, ROUND(AVG(nilai_mahasiswa.nilai), 2) as nilai_rata_rata')
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->groupBy('soal.bentuk_soal')
            ->get();

            $labels = $nilaiRataRata->pluck('bentuk_soal')->toArray();
            $values = $nilaiRataRata->pluck('nilai_rata_rata')->toArray();

            return response()->json([
                'labels' => $labels,
                'values' => $values,
            ]);
    }

    public function rataRataSubCPMK(Request $request){
        $matakuliah_kelasid = $request->matakuliah_kelasid;
        $query = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->selectRaw('ROUND(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal), 1) as nilai_rata_rata, soal_sub_cpmk.bobot_soal AS bobot_soal, sub_cpmk.kode_subcpmk')
            // ->selectRaw('sub_cpmk.kode_subcpmk, ROUND(AVG(nilai_mahasiswa.nilai), 2) as nilai_rata_rata')
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->orderBy('sub_cpmk.kode_subcpmk', 'asc')
            ->groupBy('sub_cpmk.kode_subcpmk');

        $nilaiRataRata = $query->get();

            $labels = $nilaiRataRata->pluck('kode_subcpmk')->toArray();
            $values = $nilaiRataRata->pluck('nilai_rata_rata')->toArray();

            return response()->json([
                'labels' => $labels,
                'values' => $values,
            ]);
    }

    public function rataRataCPMK(Request $request){
        $matakuliah_kelasid = $request->matakuliah_kelasid;
        $query = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->selectRaw('ROUND(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal), 1) as nilai_rata_rata, soal_sub_cpmk.bobot_soal AS bobot_soal, cpmk.kode_cpmk')
            // ->selectRaw('sub_cpmk.kode_subcpmk, ROUND(AVG(nilai_mahasiswa.nilai), 2) as nilai_rata_rata')
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->orderBy('cpmk.kode_cpmk', 'asc')
            ->groupBy('cpmk.kode_cpmk');

        // $sql = $query->toSql();
        // dd($sql);
        $nilaiRataRata = $query->get();

            $labels = $nilaiRataRata->pluck('kode_cpmk')->toArray();
            $values = $nilaiRataRata->pluck('nilai_rata_rata')->toArray();

            return response()->json([
                'labels' => $labels,
                'values' => $values,
            ]);
    }

    public function rataRataCPL(Request $request){
        $matakuliah_kelasid = $request->matakuliah_kelasid;
        $query = NilaiMahasiswa::join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->join('cpmk', 'sub_cpmk.cpmk_id', 'cpmk.id')
            ->join('cpl', 'cpmk.cpl_id', 'cpl.id')
            ->selectRaw('ROUND(SUM(nilai_mahasiswa.nilai * soal_sub_cpmk.bobot_soal) / SUM(soal_sub_cpmk.bobot_soal), 1) as nilai_rata_rata, soal_sub_cpmk.bobot_soal AS bobot_soal, cpl.kode_cpl')
            // ->selectRaw('sub_cpmk.kode_subcpmk, ROUND(AVG(nilai_mahasiswa.nilai), 2) as nilai_rata_rata')
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->orderBy('cpl.kode_cpl', 'asc')
            ->groupBy('cpl.kode_cpl');

        // $sql = $query->toSql();
        // dd($sql);
        $nilaiRataRata = $query->get();

            $labels = $nilaiRataRata->pluck('kode_cpl')->toArray();
            $values = $nilaiRataRata->pluck('nilai_rata_rata')->toArray();

            return response()->json([
                'labels' => $labels,
                'values' => $values,
            ]);
    }
}

