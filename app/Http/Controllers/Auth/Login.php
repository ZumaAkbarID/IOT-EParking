<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function form()
    {
        return view('Auth.login', [
            'title' => 'Login | E-Parking'
        ]);
    }

    public function process(Request $request)
    {
        if (Auth::attempt(['phone_number' => $request->phone, 'password' => $request->password])) {
            return redirect()->intended('/' . strtolower(Auth::user()->role));
        } else {
            return redirect()->back()->withInput()->with('error', 'Akun tidak ditemukan');
        }
    }
}
