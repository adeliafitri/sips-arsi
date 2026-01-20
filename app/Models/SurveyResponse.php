<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_form_id',
        'mahasiswa_id',
        'matakuliah_kelasid',
        'dosen_id',
        'nama_laboran',
        'nama_staf_administrasi',
        'tanggal_sempro',
        'tanggal_sidang',
        'kendala_skripsi',
        'tahun_akademik',
        'semester',
        'saran'
    ];

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    public function suggestions()
    {
        return $this->hasMany(SurveySuggestion::class);
    }

    public function form()
    {
        return $this->belongsTo(SurveyForm::class, 'survey_form_id');
    }

    public static function sudahMengisiKuisioner($mahasiswa_id, $matakuliah_kelasid, $dosen_id, $idFormKepuasan, $idFormKinerja)
    {
        $isiKepuasan = SurveyResponse::where('survey_form_id', $idFormKepuasan)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->where('dosen_id', $dosen_id)
            ->exists();

        $isiKinerja = SurveyResponse::where('survey_form_id', $idFormKinerja)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('matakuliah_kelasid', $matakuliah_kelasid)
            ->where('dosen_id', $dosen_id)
            ->exists();

        return $isiKepuasan && $isiKinerja;
    }
}
