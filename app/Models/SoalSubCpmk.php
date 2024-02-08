<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalSubCpmk extends Model
{
    use HasFactory;

    protected $table ='soal_sub_cpmk';

    protected $fillable = [
        'subcpmk_id',
        'soal_id',
        'bobot_soal',
        'waktu_pelaksanaan'
    ];
}