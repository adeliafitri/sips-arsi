<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImportExcel implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $password = $row['nim'];
        $auth =  User::create([
            'username' => $row['nim'],
            'password' => Hash::make($password),
            'role' => 'mahasiswa'
        ]);

        $id_auth = $auth->id;

        Mahasiswa::create([
            'id_auth' => $id_auth,
            'nama' => $row['nama_mahasiswa'],
            'nim' => $row['nim'],
            'telp' => $row['no_telp'],
            'angkatan' => $row['angkatan'],
        ]);
    }
}
