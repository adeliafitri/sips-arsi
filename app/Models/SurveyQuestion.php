<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_form_id',
        'kategori',
        'indikator',
        'pertanyaan'
    ];

    public function form()
    {
        return $this->belongsTo(SurveyForm::class, 'survey_form_id');
    }

}
