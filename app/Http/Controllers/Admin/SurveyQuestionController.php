<?php

namespace App\Http\Controllers\Admin;

use App\Models\SurveyForm;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class SurveyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SurveyQuestion::join('survey_forms', 'survey_questions.survey_form_id', '=', 'survey_forms.id')
            ->select('survey_questions.*', 'survey_forms.nama_formulir', 'survey_forms.id as survey_form_id');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('nama_formulir', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pertanyaan', 'like', '%' . $searchTerm . '%');
            });
        }

        $questions = $query->get();

        // Kelompokkan berdasarkan nama_formulir
        $groupedData = [];

        foreach ($questions as $q) {
            if (!isset($groupedData[$q->nama_formulir])) {
                $groupedData[$q->nama_formulir] = [
                    'id_form' => $q->survey_form_id,
                    'nama_formulir' => $q->nama_formulir,
                    'pertanyaan' => []
                ];
            }

            $groupedData[$q->nama_formulir]['pertanyaan'][] = [
                'id' => $q->id,
                'pertanyaan' => $q->pertanyaan,
                'indikator' => $q->indikator,
                'kategori' => $q->kategori,
            ];
            // if (!isset($groupedData[$q->nama_formulir])) {
            //     $groupedData[$q->nama_formulir] = [];
            // }

            // $groupedData[$q->nama_formulir][] = [
            //     'id' => $q->id,
            //     'pertanyaan' => $q->pertanyaan,
            //     'indikator' => $q->indikator,
            //     'kategori' => $q->kategori,
            // ];
        }

        // Pagination manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = array_slice($groupedData, ($currentPage - 1) * $perPage, $perPage, true);
        $paginatedData = new LengthAwarePaginator($currentItems, count($groupedData), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        $startNumber = ($paginatedData->currentPage() - 1) * $paginatedData->perPage() + 1;

        return view('pages-admin.survey_question.index', [
            'data' => $paginatedData,
            'startNumber' => $startNumber,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $idForm = $request->query('id_form');
        $namaForm = SurveyForm::where('id', $idForm)->value('nama_formulir');
        return view('pages-admin.survey_question.tambah_pertanyaan', compact('idForm', 'namaForm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'survey_form_id' => 'required',
            'kategori' => 'nullable|string',
            'indikator' => 'nullable|string',
            'pertanyaan' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            SurveyQuestion::create([
                'survey_form_id' => $request->survey_form_id,
                'kategori' => $request->kategori,
                'indikator' => $request->indikator,
                'pertanyaan' => $request->pertanyaan,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
            // return redirect()->route('admin.cpl')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
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
        $survei_form = SurveyForm::all();
        $survei_question = SurveyQuestion::find($id);

        return view('pages-admin.survey_question.edit_pertanyaan', [
            'success' => 'Data Ditemukan',
            'data_form' => $survei_form,
            'data_question' => $survei_question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            // 'survey_form_id' => 'required',
            'kategori' => 'nullable|string',
            'indikator' => 'nullable|string',
            'pertanyaan' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $survei_question = SurveyQuestion::find($id);
            $survei_question->update([
                // 'survey_form_id' => $request->survey_form_id,
                'kategori' => $request->kategori,
                'indikator' => $request->indikator,
                'pertanyaan' => $request->pertanyaan,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate', 'data' => $survei_question]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $form = SurveyQuestion::findOrFail($id);
            $form->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }
}
