<?php

namespace App\Http\Controllers\Admin;

use App\Models\SurveyForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SurveyFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SurveyForm::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('nama_formulir', 'like', '%' . $searchTerm . '%');
            });
        }

        $survei_form = $query->paginate(20);

        $startNumber = ($survei_form->currentPage() - 1) * $survei_form->perPage() + 1;

        return view('pages-admin.survey_form.index', [
            'data' => $survei_form,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Formulir Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('pages-admin.survey_form.tambah_formulir');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_formulir' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            SurveyForm::create([
                'nama_formulir' => $request->nama_formulir,
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
        $survei_form = SurveyForm::find($id);

        return view('pages-admin.survey_form.edit_formulir', [
            'success' => 'Data Ditemukan',
            'data' => $survei_form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_formulir' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first(),
            ], 422);
        }

        try {
            $survei_form = SurveyForm::find($id);
            $survei_form->update([
                'nama_formulir' => $request->nama_formulir,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate', 'data' => $survei_form]);
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
            $form = SurveyForm::findOrFail($id);
            $form->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $e->getMessage()], 500);
        }
    }
}
