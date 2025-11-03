<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_formulir',
    ];


    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
}
