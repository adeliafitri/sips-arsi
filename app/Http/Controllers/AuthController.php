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

class AuthController extends Controller
{
    public function showFormLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
            ])) {

                $user = Auth::user();
                // session()->forget(['admin', 'dosen', 'mahasiswa']);
                // dd($user->id);

                    if ($user->role === 'dosen') {
                        $dosen = dosen::where('id_auth', $user->id)->first();
                         // Simpan data dosen dalam session
                        if ($dosen) {
                            session(['dosen' => $dosen]);
                            return redirect()->route('dosen.dashboard');
                        }else {
                            return redirect()->back()->withErrors(['error' => 'dosen data not found']);
                        }
                        // return redirect()->route('dosen.dashboard');
                    } elseif ($user->role === 'mahasiswa') {
                        $mahasiswa = Mahasiswa::where('id_auth', $user->id)->first();
                         // Simpan data mahasiswa dalam session
                        if ($mahasiswa) {
                            session(['mahasiswa' => $mahasiswa]);
                            return redirect()->route('mahasiswa.dashboard');
                        }else {
                            return redirect()->back()->withErrors(['error' => 'mahasiswa data not found']);
                        }
                        // return redirect()->route('mahasiswa.dashboard');
                    } elseif ($user->role === 'admin') {
                        $admin = Admin::where('id_auth', $user->id)->first();
                         // Simpan data admin dalam session
                        if ($admin) {
                            session(['admin' => $admin]);
                            return redirect()->route('admin.dashboard');
                        }else {
                            return redirect()->back()->withErrors(['error' => 'Admin data not found']);
                        }
                    }else {
                        abort(403, 'Unauthorized');
                    }
        }

        return back()->withErrors(['error' => 'Invalid login credentials']);
    }

    public function showFormRegister() {
        return view('register');
    }

    public function register(Request $request) {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|unique:auth',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,dosen,admin',
            'nim' => 'required_if:role,mahasiswa|unique:mahasiswa,nim',
            'tanggal_lahir' => 'required_if:role,mahasiswa',
            'jenis_kelamin' => 'required_if:role,mahasiswa',
            'telp' => 'required|string|unique:mahasiswa,telp|unique:dosen,telp|unique:admin,telp',
            'nidn' => 'sometimes|required_if:role,dosen|unique:dosen,nidn'
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $register = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $id_auth = $register->id;

            if ($request->role === 'mahasiswa') {
                $mahasiswa = Mahasiswa::create([
                    'id_auth' => $id_auth,
                    'nama' => $request->nama,
                    'nim' => $request->nim,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'telp' => $request->telp,
                ]);
            }
            if ($request->role === 'dosen') {
                $dosen = Dosen::create([
                    'id_auth' => $id_auth,
                    'nama' => $request->nama,
                    'nidn' => $request->nidn,
                    'telp' => $request->telp,
                ]);
            }
            if ($request->role === 'admin') {
                $admin = Admin::create([
                    'id_auth' => $id_auth,
                    'nama' => $request->nama,
                    'telp' => $request->telp,
                ]);
            }

            return redirect()->route('login')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['registration' => $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
