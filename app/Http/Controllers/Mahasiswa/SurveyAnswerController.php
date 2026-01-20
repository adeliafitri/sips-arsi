<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Dosen;
use App\Models\SurveyForm;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveySuggestion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SurveyAnswerController extends Controller
{
    protected function getCurrentSemesterData()
    {
        $submissionTime = Carbon::now();
        $bulan = $submissionTime->month;
        $tahun = $submissionTime->year;

        if ($bulan >= 8 || $bulan <= 1) {
            $semester = 'Ganjil';
            // Menentukan Tahun Akademik (misal: 2024/2025)
            $tahunAkademik = $bulan >= 8 ? $tahun . '/' . ($tahun + 1) : ($tahun - 1) . '/' . $tahun;
        } else {
            $semester = 'Genap';
            $tahunAkademik = $tahun . '/' . $tahun;
        }

        return ['semester' => $semester, 'tahun_akademik' => $tahunAkademik];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil ID matakuliah_kelas dari query string
        $matakuliah_kelas_id = $request->query('matakuliah_kelas_id');
        $dosen_id = $request->query('dosen_id');
        // Validasi jika ID tidak ada
        if (!$matakuliah_kelas_id) {
            return redirect()->back()->with('error', 'ID Matakuliah Kelas tidak ditemukan.');
        }

        $formKepuasan = SurveyForm::where('nama_formulir', 'LIKE', '%IKM%')->first();
        $formKinerja  = SurveyForm::where('nama_formulir',  'LIKE', '%IKD%')->first();
        // dd($formKepuasan, $formKinerja);

        // Cek jika ditemukan
        if (!$formKepuasan || !$formKinerja) {
            abort(404, 'Formulir tidak ditemukan');
        }

        $kepuasanQuestions = SurveyQuestion::where('survey_form_id', $formKepuasan->id)->get();
        $kinerjaQuestions = SurveyQuestion::where('survey_form_id', $formKinerja->id)->get();
        // dd($kepuasanQuestions, $kinerjaQuestions);

        $options = [
            1 => 'Kurang',
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Sangat Baik',
        ];


        // Tampilkan form untuk mengisi survey
        return view('pages-mahasiswa.survey.create', [
            'kepuasanQuestions' => $kepuasanQuestions,
            'kinerjaQuestions' => $kinerjaQuestions,
            'id_form_kepuasan' => $formKepuasan->id,
            'id_form_kinerja' => $formKinerja->id,
            'matakuliah_kelas_id' => $matakuliah_kelas_id,
            'dosen_id' => $dosen_id,
            'options' => $options,
        ]);
    }

    public function storeKepuasan(Request $request)
    {
        $request->validate([
            'jawaban_kepuasan' => 'required|array',
            'matakuliah_kelas_id' => 'required|integer',
            'dosen_id' => 'required|integer',
        ]);

        try{
            // Simpan ke survey_responses (header)
        $surveyResponse = SurveyResponse::create([
            'survey_form_id' => $request->survey_form_id,
            'mahasiswa_id' => auth()->id(),
            'matakuliah_kelasid' => $request->matakuliah_kelas_id,
            'dosen_id' => $request->dosen_id,
            'saran' => $request->saran_kepuasan, // boleh null
        ]);

        // Simpan setiap jawaban ke survey_answers
        foreach ($request->jawaban_kepuasan as $questionId => $answer) {
            SurveyAnswer::create([
                'survey_response_id' => $surveyResponse->id,
                'survey_question_id' => $questionId,
                'skor_jawaban' => $answer,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Kuisioner Kepuasan Mahasiswa berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan kuisioner: ' . $e->getMessage()], 500);
        }
    }


    public function storeKinerja(Request $request)
    {
        $request->validate([
            'jawaban_kinerja' => 'required|array',
            'matakuliah_kelas_id' => 'required|integer',
            'dosen_id' => 'required|integer',
        ]);

        try{
            // Simpan ke survey_responses (header)
        $surveyResponse = SurveyResponse::create([
            'survey_form_id' => $request->survey_form_id,
            'mahasiswa_id' => auth()->id(),
            'matakuliah_kelasid' => $request->matakuliah_kelas_id,
            'dosen_id' => $request->dosen_id,
            'saran' => $request->saran_kinerja, // boleh null
        ]);

        // Simpan setiap jawaban ke survey_answers
        foreach ($request->jawaban_kinerja as $questionId => $answer) {
            SurveyAnswer::create([
                'survey_response_id' => $surveyResponse->id,
                'survey_question_id' => $questionId,
                'skor_jawaban' => $answer,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Kuisioner Kinerja Dosen berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan kuisioner: ' . $e->getMessage()], 500);
        }
    }

    public function createPerwalian(Request $request)
    {
        $semesterData = $this->getCurrentSemesterData();

        // Ambil semua data dosen
        $dosen = Dosen::pluck('nama', 'id');

        $formPerwalian = SurveyForm::where('nama_formulir', 'LIKE', '%Perwalian%')->first();
        // dd($formPerwalian, $formKinerja);

        // Cek jika ditemukan
        if (!$formPerwalian) {
            abort(404, 'Formulir tidak ditemukan');
        }

        $perwalianQuestions = SurveyQuestion::where('survey_form_id', $formPerwalian->id)->get();

        $options = [
            1 => 'Kurang',
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Sangat Baik',
        ];

        $semester = $semesterData['semester'];
        $tahunAkademik = $semesterData['tahun_akademik'];

        $responseSudahIsi = SurveyResponse::where('mahasiswa_id', auth()->id())
            ->where('survey_form_id', $formPerwalian->id)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik)
            ->first();

        $existingAnswers = collect();
        $existingSuggestion = $responseSudahIsi->saran ?? '';
        $isFormDisabled = false;

        if ($responseSudahIsi) {
            $isFormDisabled = true;

            // Ambil jawaban dan atur kunci berdasarkan ID pertanyaan
            $existingAnswers = SurveyAnswer::where('survey_response_id', $responseSudahIsi->id)
                ->get()
                ->keyBy('survey_question_id');
        }

        // Tampilkan form untuk mengisi survey
        return view('pages-mahasiswa.survey.create_perwalian', [
            'perwalianQuestions' => $perwalianQuestions,
            'id_form_perwalian' => $formPerwalian->id,
            'dosen' => $dosen,
            'options' => $options,
            'isFormDisabled' => $isFormDisabled,
            'existingAnswers' => $existingAnswers,
            'existingSuggestion' => $existingSuggestion,
            'dosenWaliId' => $responseSudahIsi->dosen_id ?? null,
            'tahunAkademik' => $tahunAkademik,
            'semester' => $semester,
        ]);
    }

    public function storePerwalian(Request $request)
    {
        $request->validate([
            'jawaban_perwalian' => 'required|array',
            'dosen_id' => 'required|integer',
        ]);

        try{

            $semesterData = $this->getCurrentSemesterData();
            $semester = $semesterData['semester'];
            $tahunAkademik = $semesterData['tahun_akademik'];
            // Simpan ke survey_responses (header)
            $surveyResponse = SurveyResponse::create([
                'survey_form_id' => $request->survey_form_id,
                'mahasiswa_id' => auth()->id(),
                'dosen_id' => $request->dosen_id,
                'tahun_akademik' => $tahunAkademik,
                'semester' => $semester,
                'saran' => $request->saran_perwalian, // boleh null
            ]);

            // Simpan setiap jawaban ke survey_answers
            foreach ($request->jawaban_perwalian as $questionId => $answer) {
                SurveyAnswer::create([
                    'survey_response_id' => $surveyResponse->id,
                    'survey_question_id' => $questionId,
                    'skor_jawaban' => $answer,
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Kuisioner Perwalian berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan kuisioner: ' . $e->getMessage()], 500);
        }
    }

    protected function loadExistingData($response) {
        if (!$response) {
            return [
                'isFilled' => false,
                'answers' => collect(),
                'suggestion' => null, // Default
                'kendala_skripsi' => '',
                'tanggal_sempro' => null,
                'tanggal_sidang' => null,
                'dosen_id' => null,
            ];
        }

        $answers = SurveyAnswer::where('survey_response_id', $response->id)
            ->get()
            ->keyBy('survey_question_id');

        $suggestion = $response->saran ?? null;

        // Ambil data lain yang mungkin Anda perlukan untuk ditampilkan (dari SurveyResponse)
        // $kendalaSkripsi = $response->kendala_skripsi ? explode(',', $response->kendala_skripsi) : [];

        return [
            'isFilled' => true,
            'answers' => $answers,
            'suggestion' => $suggestion, // Data Saran diambil dari sini
            'kendala_skripsi' => $response->kendala_skripsi,
            'tanggal_sempro' => $response->tanggal_sempro,
            'tanggal_sidang' => $response->tanggal_sidang,
            'dosen_id' => $response->dosen_id,
        ];
    }

    public function createPembimbingan(Request $request)
    {
        $semesterData = $this->getCurrentSemesterData();
        $semester = $semesterData['semester'];
        $tahunAkademik = $semesterData['tahun_akademik'];
        // Ambil semua data dosen
        $dosen = Dosen::pluck('nama', 'id');

        $formPembimbingan = SurveyForm::where('nama_formulir', 'LIKE', '%Pembimbingan%')->first();
        // dd($formpembimbingan, $formKinerja);

        // Cek jika ditemukan
        if (!$formPembimbingan) {
            abort(404, 'Formulir tidak ditemukan');
        }

        $pembimbinganQuestions = SurveyQuestion::where('survey_form_id', $formPembimbingan->id)->get();

        $response_dospem1 = SurveyResponse::where('mahasiswa_id', auth()->id())
            ->where('survey_form_id', $formPembimbingan->id)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik)
            ->whereNotNull('dosen_id') // Asumsi: Pembimbing 1 dan 2 dibedakan dari dosen_id
            ->first(); // Atau cari berdasarkan dosen_id khusus jika Anda membedakannya
        // dd($response_dospem1);

        $data_dospem1 = $this->loadExistingData($response_dospem1);
        // dd($data_dospem1);

        $response_dospem2 = SurveyResponse::where('mahasiswa_id', auth()->id())
            ->where('survey_form_id', $formPembimbingan->id)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik)
            // Tambahkan kondisi unik untuk Dosen Pembimbing 2 jika ada
            ->where('id', '!=', $response_dospem1->id ?? 0)
            ->first();

        $data_dospem2 = $this->loadExistingData($response_dospem2);

        // Tentukan apakah SEMUA survei pembimbingan sudah diisi
        $isFormDisabled = $data_dospem1['isFilled'] && $data_dospem2['isFilled'];

        $options = [
            1 => 'Kurang',
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Sangat Baik',
        ];

        // Tampilkan form untuk mengisi survey
        return view('pages-mahasiswa.survey.create_pembimbingan_ta', [
            'pembimbinganQuestions' => $pembimbinganQuestions,
            'id_form_pembimbingan' => $formPembimbingan->id,
            'dosen' => $dosen,
            'options' => $options,
            'isFormDisabled' => $isFormDisabled,
            'semester' => $semester,
            'tahunAkademik' => $tahunAkademik,

            'dospem1_isFilled' => $data_dospem1['isFilled'],
            'dospem1_answers' => $data_dospem1['answers'],
            'dospem1_suggestion' => $data_dospem1['suggestion'],
            'dospem1_kendala_skripsi' => $data_dospem1['kendala_skripsi'],
            'dospem1_tanggal_sempro' => $data_dospem1['tanggal_sempro'],
            'dospem1_tanggal_sidang' => $data_dospem1['tanggal_sidang'],
            'dospem1_dosen_id' => $data_dospem1['dosen_id'],

            'dospem2_isFilled' => $data_dospem2['isFilled'],
            'dospem2_answers' => $data_dospem2['answers'],
            'dospem2_suggestion' => $data_dospem2['suggestion'],
            'dospem2_kendala_skripsi' => $data_dospem2['kendala_skripsi'],
            'dospem2_tanggal_sempro' => $data_dospem2['tanggal_sempro'],
            'dospem2_tanggal_sidang' => $data_dospem2['tanggal_sidang'],
            'dospem2_dosen_id' => $data_dospem2['dosen_id'],
        ]);
    }

    public function storePembimbingan(Request $request)
    {
        $validated = $request->validate([
            'survey_form_id' => 'required|integer',
            'dosen_pembimbing1_id' => 'required|integer',
            'jawaban_pembimbingan' => 'required|array',
            'pelaksanaan_seminar' => 'required|date',
            'pelaksanaan_sidang' => 'required|date',
            'kendala' => 'required|array',
            'saran_pembimbingan' => 'required|string',
        ]);

        DB::beginTransaction();

        try{
            $semesterData = $this->getCurrentSemesterData();
            $semester = $semesterData['semester'];
            $tahunAkademik = $semesterData['tahun_akademik'];
            // Simpan jawaban untuk Pembimbing 1
            if (!empty($validated['dosen_pembimbing1_id'])) {
                $response1 = SurveyResponse::create([
                    'survey_form_id'      => $validated['survey_form_id'],
                    'mahasiswa_id'        => auth()->id(), // atau dari sesi
                    'dosen_id'            => $validated['dosen_pembimbing1_id'],
                    'tanggal_sempro'      => $validated['pelaksanaan_seminar'],
                    'tanggal_sidang'      => $validated['pelaksanaan_sidang'],
                    'kendala_skripsi'     => !empty($validated['kendala'])? implode(',', (array) $validated['kendala']): null,
                    'tahun_akademik'      => $tahunAkademik,
                    'semester'            => $semester,
                    'saran'               => $validated['saran_pembimbingan'],
                ]);

                // simpan jawaban detail (opsional kalau pakai tabel survey_answers)
                foreach ($validated['jawaban_pembimbingan'] as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response1->id,
                        'survey_question_id' => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Kuisioner Pembimbing 1 tersimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan kuisioner: ' . $e->getMessage()], 500);
        }
    }

    public function storePembimbingan2(Request $request)
    {
        $validated = $request->validate([
            'survey_form_id' => 'required|integer',
            'dosen_pembimbing2_id' => 'required|integer',
            'jawaban_pembimbingan2' => 'required|array',
            'pelaksanaan_seminar2' => 'required|date',
            'pelaksanaan_sidang2' => 'required|date',
            'kendala2' => 'required|array',
            'saran_pembimbingan2' => 'required|string',
        ]);

        DB::beginTransaction();

        try{
            $semesterData = $this->getCurrentSemesterData();
            $semester = $semesterData['semester'];
            $tahunAkademik = $semesterData['tahun_akademik'];
            // Simpan jawaban untuk Pembimbing 2// Simpan jawaban untuk Pembimbing 2
            if (!empty($validated['dosen_pembimbing2_id'])) {
                $response2 = SurveyResponse::create([
                    'survey_form_id'      => $validated['survey_form_id'],
                    'mahasiswa_id'        => auth()->id(),
                    'dosen_id'            => $validated['dosen_pembimbing2_id'],
                    'tanggal_sempro'      => $validated['pelaksanaan_seminar2'],
                    'tanggal_sidang'      => $validated['pelaksanaan_sidang2'],
                    'kendala_skripsi'     => !empty($validated['kendala'])? implode(',', (array) $validated['kendala2']): null,
                    'tahun_akademik'      => $tahunAkademik,
                    'semester'            => $semester,
                    'saran'               => $validated['saran_pembimbingan2'],
                ]);

                foreach ($validated['jawaban_pembimbingan2'] as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response2->id,
                        'survey_question_id' => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Kuisioner Pembimbing 2 tersimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan kuisioner: ' . $e->getMessage()], 500);
        }
    }


    public function createSarprasTendikProdi(Request $request)
    {
        // Ambil semua data Laboran
        $laboran = ['Abidin, S.Pd.I.', 'Anton Prasetyo, S.Si.'];
        $staffAdmin = ['Galuh Akbar Jagini'];

        $form = SurveyForm::where('nama_formulir', 'LIKE', '%Sarpras%')->first();
        // dd($formpembimbingan, $formKinerja);

        // Cek jika ditemukan
        if (!$form) {
            abort(404, 'Formulir tidak ditemukan');
        }

        $sudahIsi = SurveyResponse::where('survey_form_id', $form->id)
            ->where('mahasiswa_id', auth()->id())
            ->whereYear('created_at', now()->year)
            ->first();

        $disable = false;
        $hasilSurvey = [];

        if ($sudahIsi) {
            $disable = true;

            $kategoriList = [
                'Laboran' => 'Laboran',
                'Staf Administrasi' => 'staf_admin',
                'Manajemen Prodi' => 'manajemen_prodi',
                'Visi Misi' => 'visi_misi',
                'Roadmap Penelitian' => 'roadmap_penelitian',
                'Sarpras' => 'Sarpras',
            ];

            foreach ($kategoriList as $key => $value) {
                $answers = SurveyAnswer::where('survey_response_id', $sudahIsi->id)
                    ->whereHas('question', function ($q) use ($form, $value) {
                        $q->where('survey_form_id', $form->id)
                        ->where('kategori', 'LIKE', "%$value%");
                    })
                    ->get(['survey_question_id', 'skor_jawaban']);

                $suggestion = SurveySuggestion::where('survey_response_id', $sudahIsi->id)
                    ->where('kategori', 'LIKE', "%$value%")
                    ->first();

                $hasilSurvey[$key] = [
                    'pertanyaan' => $answers->map(function ($a) {
                        return [
                            'question_id' => $a->survey_question_id,
                            'skor_jawaban' => $a->skor_jawaban,
                        ];
                    })->toArray(),
                    'saran' => $suggestion->isi_saran ?? null,
                ];
            }
        }

        // dd($hasilSurvey);

        $laboranQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori', 'LIKE', '%Laboran%')->get();
        $staffAdminQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori', 'LIKE', '%Administrasi%')->get();
        $manajemenProdiQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori', 'LIKE', '%Manajemen Prodi%')->get();
        $visiMisiQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori', 'LIKE', '%Visi Misi%')->get();
        $roadmapPenelitianQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori', 'LIKE', '%Roadmap Penelitian%')->get();
        $sarprasQuestions = SurveyQuestion::where('survey_form_id', $form->id)->where('kategori',   'LIKE', '%Sarpras%')->get();
        // dd($pembimbinganQuestions, $kinerjaQuestions);
        // dd($laboranQuestions);

        $options = [
            1 => 'Kurang',
            2 => 'Cukup',
            3 => 'Baik',
            4 => 'Sangat Baik',
        ];


        // Tampilkan form untuk mengisi survey
        return view('pages-mahasiswa.survey.create_sarpras', [
            'laboranQuestions' => $laboranQuestions,
            'staffAdminQuestions' => $staffAdminQuestions,
            'manajemenProdiQuestions' => $manajemenProdiQuestions,
            'visiMisiQuestions' => $visiMisiQuestions,
            'roadmapPenelitianQuestions' => $roadmapPenelitianQuestions,
            'sarprasQuestions' => $sarprasQuestions,
            'laboran' => $laboran,
            'staffAdmin' => $staffAdmin,
            'id_form_sarpras' => $form->id,
            'options' => $options,
            'disable' => $disable,
            'sudahIsi' => $sudahIsi,
            'tahunSekarang' => now()->year,
            'hasilSurvey' => $hasilSurvey,
            'nama_laboran' => $sudahIsi->nama_laboran ?? null,
            'nama_staff_admin' => $sudahIsi->nama_staf_administrasi ?? null,
            'tanggal_sempro' => $sudahIsi->tanggal_sempro ?? null,
            'tanggal_sidang' => $sudahIsi->tanggal_sidang ?? null,
            'kendala_skripsi' => $sudahIsi?->kendala_skripsi ? explode(',', $sudahIsi->kendala_skripsi) : [],
            // 'kendala_skripsi' => $sudahIsi->kendala_skripsi ? explode(',', $sudahIsi->kendala_skripsi) : [],
            // 'jawabanLaboran' => $jawabanLaboran ?? [],
        ]);
    }

    public function storeSarprasTendikProdi(Request $request)
    {
         DB::beginTransaction();
        try {
            // simpan response utama
            $response = SurveyResponse::create([
                'survey_form_id' => $request->survey_form_id,
                'mahasiswa_id'   => auth()->id(),
                'nama_laboran' => $request->input('nama_laboran'),
                'nama_staf_administrasi' => $request->input('nama_staf_administrasi'),
            ]);

            // =============================
            // 1. Jawaban Laboran
            // =============================
            if ($request->has('jawaban_laboran')) {
                foreach ($request->jawaban_laboran as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_laboran')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'laboran',
                        'isi_saran'          => $request->saran_laboran,
                    ]);
                }
            }

            // =============================
            // 2. Jawaban Staf Admin
            // =============================
            if ($request->has('jawaban_staf_administrasi')) {
                foreach ($request->jawaban_staf_administrasi as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_staf_administrasi')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'staf_admin',
                        'isi_saran'          => $request->saran_staf_administrasi,
                    ]);
                }
            }

            // =============================
            // 3. Jawaban Manajemen Prodi
            // =============================
            if ($request->has('jawaban_manajemen_prodi')) {
                foreach ($request->jawaban_manajemen_prodi as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_manajemen_prodi')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'manajemen_prodi',
                        'isi_saran'          => $request->saran_manajemen_prodi,
                    ]);
                }
            }

            // =============================
            // 4. Jawaban Visi Misi
            // =============================
            if ($request->has('jawaban_visi_misi')) {
                foreach ($request->jawaban_visi_misi as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_visi_misi')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'visi_misi',
                        'isi_saran'          => $request->saran_visi_misi,
                    ]);
                }
            }

            // =============================
            // 5. Jawaban Roadmap
            // =============================
            if ($request->has('jawaban_roadmap')) {
                foreach ($request->jawaban_roadmap as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_roadmap')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'roadmap_penelitian',
                        'isi_saran'          => $request->saran_roadmap,
                    ]);
                }
            }

            // =============================
            // 6. Jawaban Sarpras
            // =============================
            if ($request->has('jawaban_sarpras')) {
                foreach ($request->jawaban_sarpras as $questionId => $answer) {
                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'survey_question_id'        => $questionId,
                        'skor_jawaban'       => $answer,
                    ]);
                }

                if ($request->filled('saran_sarpras')) {
                    SurveySuggestion::create([
                        'survey_response_id' => $response->id,
                        'kategori'           => 'sarpras',
                        'isi_saran'          => $request->saran_sarpras,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Kuisioner berhasil disimpan',
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
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
