<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login (Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'cashier') {
                return redirect()->route('pos');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->back();
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Fungsi untuk register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Setelah berhasil, arahkan ke halaman login atau halaman lain
        return redirect()->route('form-login')->with('success', 'Account created successfully. Please login.');
    }

    public function logot()
    {
        Auth::logout();
        return redirect('/');
    }
}
