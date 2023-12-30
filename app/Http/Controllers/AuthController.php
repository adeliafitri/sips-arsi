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

        if (Auth::attempt($credentials)) {
                $user = Auth::user();
                // session()->forget(['admin', 'dosen', 'mahasiswa']);
                // dd($user->id);
                switch ($user->role) {
                    case 'admin':
                        $userData = Admin::where('id_auth', $user->id)->first();
                        break;
                    case 'dosen':
                        $userData = Dosen::where('id_auth', $user->id)->first();
                        break;
                    case 'mahasiswa':
                        $userData = Mahasiswa::where('id_auth', $user->id)->first();
                        break;
                    default:
                        return response()->json(['error' => 'Invalid user role'], 401);
                }
                return $this->respondWithToken(auth()->attempt($credentials), $userData);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    protected function respondWithToken($token, $userData)
    {
        // $customClaims = ['role' => $user->role]; // Sesuaikan dengan kolom yang sesuai
        // $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'name' => $userData->name,
                'image' => $userData->image,
                // tambahkan informasi lain yang mungkin dibutuhkan
            ],
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
