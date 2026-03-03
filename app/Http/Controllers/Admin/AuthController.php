<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error','Email atau password salah');
        }

        session(['admin_id' => $admin->id]);
        return redirect('/admin/dashboard');
    }

  public function profile()
{
    $admin = \App\Models\Admin::find(session('admin_id'));
    return view('admin.profile', compact('admin'));
}

public function updateProfile(Request $request)
{
    $admin = \App\Models\Admin::find(session('admin_id'));

    if (!$admin) {
        return redirect('/admin/login');
    }

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'current_password' => 'nullable',
        'new_password' => 'nullable|min:6|confirmed',
    ]);

    // Update data basic
    $admin->name = $request->name;
    $admin->email = $request->email;

    // Jika isi password → update password
    if ($request->filled('current_password')) {

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Password lama salah');
        }

        $admin->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
    }

    $admin->save();

    return back()->with('success', 'Profil berhasil diupdate');
}

   public function logout()
{
    session()->forget('admin_id');
    return redirect('/admin/login')->with('success', 'Berhasil logout');
}
}
