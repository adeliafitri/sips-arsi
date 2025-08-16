<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\NilaiAkhirMahasiswa;

class NilaiAkhirDownloadExcel implements FromView, ShouldAutoSize
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        // $id = $this->request->route('id');

        $data = NilaiAkhirMahasiswa::join('mahasiswa', 'nilaiakhir_mahasiswa.mahasiswa_id', 'mahasiswa.id')
            ->join('matakuliah_kelas', 'nilaiakhir_mahasiswa.matakuliah_kelasid', 'matakuliah_kelas.id')
            ->join('kelas', 'matakuliah_kelas.kelas_id', 'kelas.id')
            ->join('rps', 'matakuliah_kelas.rps_id', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', 'mata_kuliah.id')
            ->select('mata_kuliah.kode_matkul', 'mahasiswa.nim', 'kelas.nama_kelas as kelas', 'nilaiakhir_mahasiswa.nilai_akhir')
            ->where('matakuliah_kelas.id', $this->id)
            ->get();

        return view('pages-dosen.generate.excel.nilai-akhir-download', [
            'data' => $data,
        ]);
    }
}
