<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImportExcel implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $password = 'dosen123';
        $auth =  User::create([
            'username' => $row['email'],
            'password' => Hash::make($password),
            'role' => 'dosen'
        ]);

        $id_auth = $auth->id;

        Dosen::create([
            'id_auth' => $id_auth,
            'nama' => $row['nama'],
            'nidn' => $row['nidn'],
            'telp' => $row['no_telp'],
            'email' => $row['email'],
        ]);
    }
}
