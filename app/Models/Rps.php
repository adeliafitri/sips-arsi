<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    use HasFactory;

    protected $table ='rps';

    protected $fillable = [
        'matakuliah_id',
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
