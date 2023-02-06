<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Controller
{
    public function process()
    {
        try {
            Auth::logout();
            Session::regenerate(true);
            return redirect()->to(route('Auth.Login'))->with('success', 'Logout berhasil');
        } catch (\Exception $th) {
            return $th;
        }
    }
}