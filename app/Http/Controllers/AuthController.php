<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showFormLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required|string',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if ($token = Auth::attempt($credentials)) {
                $user = Auth::user();
                // session()->forget(['admin', 'dosen', 'mahasiswa']);
                // dd($user->id);
                if ($user->role === 'dosen') {
                    $dosen = dosen::where('id_auth', $user->id)->first();
                     // Simpan data dosen dalam session
                    if ($dosen) {
                        session(['dosen' => $dosen]);
                        return redirect()->route('dosen.dashboard')->with($token);
                    }else {
                        return redirect()->back()->withErrors(['error' => 'dosen data not found']);
                    }
                    // return redirect()->route('dosen.dashboard');
                } elseif ($user->role === 'mahasiswa') {
                    $mahasiswa = Mahasiswa::where('id_auth', $user->id)->first();
                     // Simpan data mahasiswa dalam session
                    if ($mahasiswa) {
                        session(['mahasiswa' => $mahasiswa]);
                        return redirect()->route('mahasiswa.dashboard')->with($token);
                    }else {
                        return redirect()->back()->withErrors(['error' => 'mahasiswa data not found']);
                    }
                    // return redirect()->route('mahasiswa.dashboard');
                } elseif ($user->role === 'admin') {
                    $admin = Admin::where('id_auth', $user->id)->first();
                     // Simpan data admin dalam session
                    if ($admin) {
                        session(['admin' => $admin]);
                        return redirect()->route('admin.dashboard')->with($token);
                    }else {
                        return redirect()->back()->withErrors(['error' => 'Admin data not found']);
                    }
                }else {
                    abort(403, 'Unauthorized');
                }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
