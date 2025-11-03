<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_response_id',
        'kategori',
        'isi_saran'
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class);
    }
}
