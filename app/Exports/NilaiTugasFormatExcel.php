<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\NilaiMahasiswa;

class NilaiTugasFormatExcel implements FromView, ShouldAutoSize
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        // $id = $this->request->route('id');

        $nilai_mahasiswa = NilaiMahasiswa::join('mahasiswa', 'nilai_mahasiswa.mahasiswa_id', 'mahasiswa.id')
            ->join('matakuliah_kelas', 'nilai_mahasiswa.matakuliah_kelasid', 'matakuliah_kelas.id')
            ->join('rps', 'matakuliah_kelas.rps_id', 'rps.id')
            ->join('mata_kuliah', 'rps.matakuliah_id', 'mata_kuliah.id')
            ->join('soal_sub_cpmk', 'nilai_mahasiswa.soal_id', 'soal_sub_cpmk.id')
            ->join('sub_cpmk', 'soal_sub_cpmk.subcpmk_id', 'sub_cpmk.id')
            ->join('soal', 'soal_sub_cpmk.soal_id', 'soal.id')
            ->select('mahasiswa.nim', 'mahasiswa.nama', 'soal_sub_cpmk.id', 'soal_sub_cpmk.waktu_pelaksanaan', 'sub_cpmk.kode_subcpmk', 'soal_sub_cpmk.bobot_soal', 'soal.bentuk_soal','nilai_mahasiswa.id as id_nilai','nilai_mahasiswa.mahasiswa_id as id_mhs', 'nilai_mahasiswa.matakuliah_kelasid as id_kelas', 'nilai_mahasiswa.nilai')
            ->where('matakuliah_kelas.id', $this->id)
            ->orderby('soal_sub_cpmk.id', 'ASC')
            ->get();

        $mahasiswa_data = [];
        $info_soal = [];
        $nomor = 1;

        foreach ($nilai_mahasiswa as $nilai) {
            $soal_id = $nilai->id;
            $mahasiswa_id = $nilai->nim;

            if (!isset($info_soal[$soal_id])) {
                $info_soal[$soal_id] = [
                    'waktu_pelaksanaan' => $nilai->waktu_pelaksanaan,
                    'kode_subcpmk' => $nilai->kode_subcpmk,
                    'bobot_soal' => $nilai->bobot_soal,
                    'bentuk_soal' => $nilai->bentuk_soal,
                ];
            }

            if (!isset($mahasiswa_data[$mahasiswa_id])) {
                $mahasiswa_data[$mahasiswa_id] = [
                    'kelas_id' => $nilai->id_kelas,
                    'id_mhs' => $nilai->id_mhs,
                    'nim' => $nilai->nim,
                    'nama' => $nilai->nama,
                    'id_nilai' => [],
                    'nomor' => $nomor
                    // 'nilai' => [],
                ];
                $nomor++;
            }

            $mahasiswa_data[$mahasiswa_id]['id_nilai'][] = $nilai->id_nilai;
            // $mahasiswa_data[$mahasiswa_id]['nilai'][] = $nilai->nilai;
        }

        return view('pages-dosen.generate.excel.nilai-mahasiswa', [
            'mahasiswa_data' => $mahasiswa_data,
            'info_soal' => $info_soal
        ]);
    }
}
