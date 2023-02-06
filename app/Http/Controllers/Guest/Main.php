<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Main extends Controller
{
    public function index(Request $request)
    {
        if ($request->tempat) {
            $total = rand(5, 100);
            $available = rand(0, $total);

            return view('Guest.info', [
                'place' => $request->tempat,
                'available' => $available,
                'total' => $total
            ]);
        }
        return view('Layouts.guest', [
            'title' => 'Landing Page'
        ]);
    }
}