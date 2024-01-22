<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id) {
        // dd($id);
        $admin = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
                    ->where('admin.id_auth', $id)
                    ->select('admin.*', 'auth.role') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();
        // dd($admin);
        if (!$admin) {
            return redirect()->route('pages-admin.admin.detail_user')->withErrors(['error' => 'Admin not found']);
        }
        return view('pages-admin.admin.detail_user', [
            'success' => 'Data Found',
            'data' => $admin,
        ]);
    }

    public function edit($id) {
        // dd($id);
        $admin = Admin::join('auth', 'admin.id_auth', '=', 'auth.id')
                    ->where('admin.id_auth', $id)
                    ->select('admin.*', 'auth.username') // Sesuaikan dengan kolom-kolom yang Anda butuhkan dari tabel auth
                    ->first();
        // dd($admin);
        if (!$admin) {
            return redirect()->route('pages-admin.admin.edit_user')->withErrors(['error' => 'Admin not found']);
        }
        return view('pages-admin.admin.edit_user', [
            'success' => 'Data Found',
            'data' => $admin,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'telp' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

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
            $admin = Admin::where('id_auth', $id)->first();
            $admin->update([
                'nama' => $request->nama,
                'telp' => $request->telp,
                'image' => $image ? $image : $admin->image,
            ]);
            session(['admin' => $admin]);
            //dd($admin->getAttributes()); // Mengecek apakah atribut sudah di-update sesuai harapan

            return redirect()->route('admin.user', $id)->with([
                'success' => 'User updated successfully.',
                'data' => $admin
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.user.edit', $id)->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    public function showFormChangePass() {
        return view('pages-admin.admin.changePass');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Please enter your old password.',
            'new_password.required' => 'Please enter a new password.',
            'new_password.min' => 'The new password must be at least 8 characters.',
            'confirm_password.required' => 'Please confirm your new password.',
            'confirm_password.same' => 'The confirmation password does not match the new password.',
        ]);

        $currentPasswordStatus = Hash::check($request->old_password, auth()->user()->password);
        if($currentPasswordStatus){

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->back()->with('success','Password Updated Successfully');
        }else{

            return redirect()->back()->with('error','Current Password does not match with Old Password');
        }
    }
}
