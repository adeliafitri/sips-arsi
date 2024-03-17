<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\NilaiAkhirMahasiswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DaftarMahasiswaImportExcel implements ToModel, WithHeadingRow
{
    private $matakuliah_kelasid;

    public function __construct($matakuliah_kelasid)
    {
        $this->matakuliah_kelasid = $matakuliah_kelasid;
    }

    public function model(array $row)
    {
        $nim = $row['nim'];
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            $nilaiAkhirMahasiswa = new NilaiAkhirMahasiswa();
            $nilaiAkhirMahasiswa->mahasiswa_id = $mahasiswa->id;
            $nilaiAkhirMahasiswa->matakuliah_kelasid = $this->matakuliah_kelasid;
            $nilaiAkhirMahasiswa->save();
        }
    }
}
