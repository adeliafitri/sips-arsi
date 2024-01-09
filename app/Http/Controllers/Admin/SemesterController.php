<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function index()
    {
        $query = Semester::select();

        $semester = $query->paginate(5);

        $startNumber = ($semester->currentPage() - 1) * $semester->perPage() + 1;


        return view('pages-admin.semester.semester', [
            'data' => $semester,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Dosen Ditemukan');
    }

    public function create()
    {
        return view('pages-admin.semester.tambah_semester');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tahun_ajaran' => 'required',
            'semester' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            Semester::create([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'is_active' => '0'
            ]);

            return redirect()->route('admin.semester')->with('success', 'Data Semester Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: ' . $e->getMessage()])->withInput();
        }
    }

    public function updateIsActive(Request $request, int $id)
    {
        try {

            $semester = Semester::where('id', $id)->first();

            $semester->update([
                'is_active' => $request->is_active
            ]);

            return redirect()->route('admin.semester')->with('success', 'Data Berhasil diupdate');
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.semester')->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $semester = Semester::where('id', $id)->first();

        return view('pages-admin.semester.edit_semester', [
            'success' => 'Data Ditemukan',
            'data' => $semester,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validate = Validator::make($request->all(), [
            'tahun_ajaran' => 'required',
            'semester' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $semester = Semester::where('id', $id)->first();

            $semester->update([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester
            ]);

            return redirect()->route('admin.semester')->with('success', 'Data Semester Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Diubah: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Semester::where('id', $id)->delete();

            return redirect()->route('admin.semester')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.semester')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
