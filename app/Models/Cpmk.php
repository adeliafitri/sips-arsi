<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $table ='cpmk';

    protected $fillable = [
        'matakuliah_id',
        'cpl_id',
        'kode_cpmk',
        'deskripsi',
    ];

    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }
    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
    public function sub_cpmk()
    {
        return $this->hasMany(SubCpmk::class, 'cpmk_id');
    }
}
