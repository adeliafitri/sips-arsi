<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::join('auth', 'mahasiswa.id_auth', '=', 'auth.id')
        ->select('mahasiswa.*', 'auth.username as username');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('mahasiswa.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mahasiswa.nim', 'like', '%' . $searchTerm . '%');
            });
        }

        $mahasiswa = $query->paginate(5);

        $startNumber = ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + 1;

        return view('pages-admin.mahasiswa.mahasiswa', [
            'data' => $mahasiswa,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Mahasiswa Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.mahasiswa.tambah_mahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nim' => 'required|unique:mahasiswa,nim',
            'telp' => 'required|string|unique:mahasiswa,telp',
            'angkatan' => 'required|numeric',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $image = null;

            // Jika ada file gambar yang diunggah, proses upload
            if ($request->hasFile('image')) {
                $image = time() . '_' . $request->file('image')->getClientOriginalName();

                while (Storage::exists('public/image/' . $image)) {
                    $image = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                }

                $request->file('image')->storeAs('public/image', $image);
            }

            $angkatan = Carbon::createFromFormat('Y', $request->angkatan)->format('Y');
            $nim = ($request->nim);
            // $tanggalLahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
            $password = $nim;
            $register = User::create([
                'username' => $request->nim,
                'password' => Hash::make($password),
                'role' => 'mahasiswa',
            ]);

            $id_auth = $register->id;

            Mahasiswa::create([
                'id_auth' => $id_auth,
                'nama' => $request->nama,
                'nim' => $request->nim,
                'telp' => $request->telp,
                'angkatan' => $angkatan,
                'image' => $image
            ]);

            return redirect()->route('admin.mahasiswa')->with('success', 'Data Mahasiswa Berhasil Ditambahkan');
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace());
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::join('auth', 'mahasiswa.id_auth', '=', 'auth.id')
                    ->where('mahasiswa.id', $id)
                    ->select('mahasiswa.*', 'auth.username') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();

        return view('pages-admin.mahasiswa.detail_mahasiswa', [
            'success' => 'Data Ditemukan',
            'data' => $mahasiswa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::join('auth', 'mahasiswa.id_auth', '=', 'auth.id')
                    ->where('mahasiswa.id', $id)
                    ->select('mahasiswa.*', 'auth.username') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();

        return view('pages-admin.mahasiswa.edit_mahasiswa', [
            'success' => 'Data Ditemukan',
            'data' => $mahasiswa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'nullable|min:8',
            'nama' => 'required|string',
            'nim' => 'required',
            'angkatan' => 'required|numeric',
            // 'tanggal_lahir' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'alamat' => 'required',
            'telp' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $angkatan = Carbon::createFromFormat('Y', $request->angkatan)->format('Y');
            // $tanggalLahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
            $image = null;

            // Jika ada file gambar yang diunggah, proses upload
            if ($request->hasFile('image')) {
                $image = time() . '_' . $request->file('image')->getClientOriginalName();

                while (Storage::exists('public/image/' . $image)) {
                    $image = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                }

                $request->file('image')->storeAs('public/image', $image);
            }

            // Update data produk berdasarkan ID
            $mahasiswa = Mahasiswa::where('id', $id)->first();
            $password = $request->password;

            if($password){
                $user = User::Where('id_auth', $mahasiswa->id_auth)->first();

                $user->update([
                        'password' => $password ? Hash::make($password) : $user->password,
                ]);
            }

            $mahasiswa->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'telp' => $request->telp,
                'angkatan' => $angkatan,
                'image' => $image ? $image : $mahasiswa->image,
            ]);

            return redirect()->route('admin.mahasiswa')->with([
                'success' => 'User updated successfully.',
                'data' => $mahasiswa
            ]);
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.mahasiswa.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::where('id_auth', $id)->delete();
            if ($mahasiswa) {
                User::where('id', $id)->delete();
                return redirect()->route('admin.mahasiswa')
                ->with('success', 'Data berhasil dihapus');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
