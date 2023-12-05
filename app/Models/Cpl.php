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
        'jeniscpl_id',
    ];

    public function jenis_cpl()
    {
        return $this->belongsTo(JenisCpl::class);
    }

    public function cpmk()
    {
        return $this->hasMany(Cpmk::class);
    }
}
