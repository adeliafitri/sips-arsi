<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table ='mata_kuliah';

    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks',
        'semester',
        'tahun_rps',
    ];

    public function cpmk()
    {
        return $this->hasMany(Cpmk::class);
    }
    public function kelas_kuliah()
    {
        return $this->hasMany(KelasKuliah::class);
    }
}
