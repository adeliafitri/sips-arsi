<?php
// app/Services/SurveyService.php
namespace App\Services;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;

class SurveyService
{
    private function calculateSurvey($dosenId, $formId, $tahun, $semester)
    {
        $semesterDb = ucfirst(strtolower($semester));

        $data = SurveyAnswer::join('survey_questions', 'survey_answers.survey_question_id', '=', 'survey_questions.id')
            ->join('survey_responses', 'survey_answers.survey_response_id', '=', 'survey_responses.id')
            ->join('matakuliah_kelas', 'survey_responses.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.tahun_ajaran', $tahun)
            ->where('semester.semester', $semesterDb)
            ->where('survey_responses.dosen_id', $dosenId)
            ->where('survey_responses.survey_form_id', $formId)
            ->select('survey_questions.indikator', DB::raw('AVG(survey_answers.skor_jawaban) as skor'))
            ->groupBy('survey_questions.pertanyaan')
            ->get();

        // Hitung total sesuai rumus IKM/IKD = total skor / (jumlah responden * jumlah pertanyaan)
        $totalSkor = SurveyAnswer::join('survey_responses', 'survey_answers.survey_response_id', '=', 'survey_responses.id')
            ->join('matakuliah_kelas', 'survey_responses.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.tahun_ajaran', $tahun)
            ->where('semester.semester', $semesterDb)
            ->where('survey_responses.dosen_id', $dosenId)
            ->where('survey_responses.survey_form_id', $formId)
            ->sum('survey_answers.skor_jawaban');

        $jumlahResponden = SurveyAnswer::join('survey_responses', 'survey_answers.survey_response_id', '=', 'survey_responses.id')
            ->join('matakuliah_kelas', 'survey_responses.matakuliah_kelasid', '=', 'matakuliah_kelas.id')
            ->join('semester', 'matakuliah_kelas.semester_id', '=', 'semester.id')
            ->where('semester.tahun_ajaran', $tahun)
            ->where('semester.semester', $semesterDb)
            ->where('survey_responses.dosen_id', $dosenId)
            ->where('survey_responses.survey_form_id', $formId)
            ->distinct('survey_responses.id')
            ->count('survey_responses.id');

        $jumlahPertanyaan = $data->count();

        $total = 0;
        if ($jumlahResponden > 0 && $jumlahPertanyaan > 0) {
            $total = round($totalSkor / ($jumlahResponden * $jumlahPertanyaan), 2);
        }

        return [
            'ikm_total' => $total,
            'per_pertanyaan' => $data->map(fn($item) => [
                'pertanyaan' => $item->indikator,
                'skor'       => round($item->skor, 2),
            ])->toArray(),
        ];
    }

    /**
     * Ambil data survei untuk IKM & IKD sekaligus
     */
    public function getSurveyData($dosenId, $tahun, $semester)
    {
        $ikm = $this->calculateSurvey($dosenId, 1, $tahun, $semester); // survey_form_id 2 = IKM
        $ikd = $this->calculateSurvey($dosenId, 2, $tahun, $semester); // survey_form_id 3 = IKD

        return [
            'ikm_total'      => $ikm['ikm_total'],
            'per_pertanyaan' => $ikm['per_pertanyaan'],
            'ikd_total'      => $ikd['ikm_total'],
            'ikd_pertanyaan' => $ikd['per_pertanyaan'],
        ];
    }
}

?>
