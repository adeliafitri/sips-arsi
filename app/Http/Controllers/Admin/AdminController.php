<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard() {
        return view('pages-admin.dashboard');
    }

    public function index(Request $request) {
        $query = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
        ->select('admin.*');

        // Cek apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('admin.nama', 'like', '%' . $searchTerm . '%');
            });
        }

        $admin = $query->paginate(5);

        $startNumber = ($admin->currentPage() - 1) * $admin->perPage() + 1;

        return view('pages-admin.admin.admins', [
            'data' => $admin,
            'startNumber' => $startNumber,
        ])->with('success', 'Data Admin Ditemukan');
    }

    public function create() {
        return view('pages-admin.admin.tambah_admin');
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email',
            'telp' => 'required',
        ]);
        // dd($validate);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $password = 'admin123';
            $auth = User::create([
                'username' => $request->email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $id_auth = $auth->id;

            Admin::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'id_auth' => $id_auth
            ]);

            return redirect()->route('admin.admins')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Data Gagal Ditambahkan: '.$e->getMessage()])->withInput();
        }
    }

    public function detailUser(){
        return view('pages-admin.admin.detail_user');
    }

    public function edit($id) {
        // dd($id);
        $admin = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
                    ->where('admin.id', $id)
                    ->select('admin.*', 'auth.username') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();
        // dd($admin);
        if (!$admin) {
            return redirect()->route('admin.admins')->withErrors(['error' => 'Admin not found']);
        }
        return view('pages-admin.admin.edit_admin', [
            'success' => 'Data Found',
            'data' => $admin,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'telp' => 'required|string',
            'email' => 'required|string',
        ]);

        try {
            // Update data produk berdasarkan ID
            $admin = Admin::where('id', $id)->first();
            $admin->update([
                'nama' => $request->nama,
                'telp' => $request->telp,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.admins')->with([
                'success' => 'User updated successfully.',
                'data' => $admin
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.admins.edit', $id)->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $admin = Admin::where('id_auth', $id)->delete();
            if ($admin) {
                User::where('id', $id)->delete();
                return redirect()->route('admin.admins')
                ->with('success', 'Data berhasil dihapus');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.admins')
                ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
