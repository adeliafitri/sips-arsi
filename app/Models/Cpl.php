<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    use HasFactory;

    protected $table ='cpl';

    protected $fillable = [
        'kode_cpl',
        'deskripsi',
        'jenis_cpl',
    ];

    public function cpmk()
    {
        return $this->hasMany(Cpmk::class);
    }
}
