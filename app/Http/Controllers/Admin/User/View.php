<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;

class View extends Controller
{
    public function all(Request $request)
    {
        $data = [
            'admin' => User::where('role', 'Admin')->get(),
            'pengurus' => User::where('role', 'Pengurus')->get(),
            'all' => User::all(),
            'business' => Business::all(),
        ];

        return view('Admin.User.all', [
            'title' => 'Data User | E-Parking',
            'data' => $data
        ]);
    }
}
