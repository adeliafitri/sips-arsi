<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dosen::join('auth', 'dosen.id_auth', '=', 'auth.id')
        ->select('dosen.*', 'auth.email as email');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('dosen.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('dosen.nidn', 'like', '%' . $searchTerm . '%');
            });
        }

        $dosen = $query->paginate(5);

        $startNumber = ($dosen->currentPage() - 1) * $dosen->perPage() + 1;

        return view('pages-admin.dosen.dosen', [
            'data' => $dosen,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Dosen Ditemukan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages-admin.dosen.tambah_dosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|unique:auth',
            'nidn' => 'required|unique:dosen,nidn',
            'telp' => 'required|string|unique:dosen,telp',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            $password = 'dosen1234';
            $register = User::create([
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'dosen',
            ]);

            $id_auth = $register->id;

            Dosen::create([
                'id_auth' => $id_auth,
                'nama' => $request->nama,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'image' => $image
            ]);

            return redirect()->route('admin.dosen')->with('success', 'Data Dosen Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
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
    public function edit($id)
    {
        $dosen = Dosen::join('auth', 'dosen.id_auth', '=', 'auth.id')
                    ->where('dosen.id', $id)
                    ->select('dosen.*', 'auth.email') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();

        return view('pages-admin.dosen.edit_dosen', [
            'success' => 'Data Ditemukan',
            'data' => $dosen,
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
            'nidn' => 'required',
            'telp' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            // Update data produk berdasarkan ID
            $dosen = Dosen::where('id', $id)->first();
            $password = $request->password;

            if($password){
                $user = User::Where('id_auth', $dosen->id_auth)->first();

                $user->update([
                        'password' => $password ? Hash::make($password) : $user->password,
                ]);
            }

            $dosen->update([
                'nama' => $request->nama,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'image' => $image ? $image : $dosen->image,
            ]);

            return redirect()->route('admin.dosen')->with([
                'success' => 'Data Berhasil diupdate',
                'data' => $dosen
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace()); // Tambahkan ini untuk melihat pesan kesalahan
            return redirect()->route('admin.dosen.edit', $id)->with('error', 'Data Gagal Diupdate: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Dosen::where('id', $id)->delete();

            return redirect()->route('admin.dosen')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.dosen')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
