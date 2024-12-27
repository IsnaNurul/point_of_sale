<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login (Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'kasir') {
                return redirect()->route('pos');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->back();
        }
    }

    public function logot()
    {
        Auth::logout();
        return redirect('/');
    }
}
