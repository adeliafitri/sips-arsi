<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function evaluasiPerwalian(Request $request)
    {
        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', '1')
            ->first();

        $tahun = $request->tahun_ajaran ?? $semesterAktif->tahun_ajaran;
        $semester = $request->semester ?? $semesterAktif->semester;
        // dd($tahun, $semester);
        $semesterDb = ucfirst(strtolower($semester));


        // List tahun ajaran untuk dropdown
        $listTahun = Semester::select('tahun_ajaran')
            ->distinct()
            ->orderBy('tahun_ajaran', 'desc')
            ->pluck('tahun_ajaran');

        $barData = SurveyResponse::join('survey_forms', 'survey_responses.survey_form_id', '=', 'survey_forms.id')
            ->join('dosen', 'survey_responses.dosen_id', '=', 'dosen.id')
            ->where('survey_forms.nama_formulir', 'LIKE','%Perwalian%')
            ->selectRaw('dosen.nama, COUNT(DISTINCT survey_responses.mahasiswa_id) as total_responden')
            ->where('survey_responses.tahun_akademik',$tahun)
            ->where('survey_responses.semester',$semesterDb)
            ->groupBy('dosen.nama')
            ->orderBy('dosen.nama')
            ->get();
        // dd($barData);

        $barLabels = $barData->pluck('nama');
        $barValues = $barData->pluck('total_responden');

        $categories = SurveyQuestion::join('survey_forms', 'survey_questions.survey_form_id', '=', 'survey_forms.id')
            ->where('survey_forms.nama_formulir', 'LIKE','%Perwalian%')
            ->select('kategori')
            ->distinct()
            ->pluck('kategori');

        $pieData = [];

        foreach ($categories as $kategori) {

            $result = SurveyAnswer::join('survey_questions', 'survey_answers.survey_question_id', '=', 'survey_questions.id')
                ->join('survey_responses', 'survey_answers.survey_response_id', '=', 'survey_responses.id')
                ->join('survey_forms', 'survey_questions.survey_form_id', '=', 'survey_forms.id')
                ->where('survey_forms.nama_formulir', 'LIKE','%Perwalian%')
                ->where('survey_questions.kategori', $kategori)
                ->where('survey_responses.tahun_akademik',$tahun)
                ->where('survey_responses.semester',$semesterDb)
                ->selectRaw("
                    SUM(CASE WHEN survey_answers.skor_jawaban = 1 THEN 1 ELSE 0 END) as sangat_baik,
                    SUM(CASE WHEN survey_answers.skor_jawaban = 2 THEN 1 ELSE 0 END) as baik,
                    SUM(CASE WHEN survey_answers.skor_jawaban = 3 THEN 1 ELSE 0 END) as cukup,
                    SUM(CASE WHEN survey_answers.skor_jawaban = 4 THEN 1 ELSE 0 END) as kurang
                ")
                ->first();

            $sangatBaik = $result->sangat_baik ?? 0;
            $baik       = $result->baik ?? 0;
            $cukup      = $result->cukup ?? 0;
            $kurang     = $result->kurang ?? 0;

            $total = $sangatBaik + $baik + $cukup + $kurang;

            $pieData[$kategori] = [
                'count' => [
                    $sangatBaik,
                    $baik,
                    $cukup,
                    $kurang
                ],
                'percent' => [
                    'Sangat Baik' => $total > 0 ? round(($sangatBaik / $total) * 100, 2) : 0,
                    'Baik'        => $total > 0 ? round(($baik / $total) * 100, 2) : 0,
                    'Cukup'       => $total > 0 ? round(($cukup / $total) * 100, 2) : 0,
                    'Kurang'      => $total > 0 ? round(($kurang / $total) * 100, 2) : 0,
                ]
            ];
        }

        return view('pages-admin.evaluasi_survei.perwalian',[
            'barLabels' => $barLabels,
            'barValues' => $barValues,
            'pieData'   => $pieData,
            'listTahun'=> $listTahun,
            'tahun' => $tahun,
            'semester' => $semester
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
