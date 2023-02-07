<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class Main extends Controller
{
    public function index(Request $request)
    {
        if ($request->uuid) {

            $query = Business::where('uuid', $request->uuid)->first();

            return view('Guest.info', [
                'title' => $query->business_name,
                'place' => $query->business_name,
                'available' => rand(0, 10),
                'total' => rand(10, 20),
            ]);
        }

        return view('Guest.landing', [
            'title' => 'Landing Page',
        ]);
    }

    public function search(Request $request)
    {
        abort_if(!$request->ajax(), 403, 'Akses ditolak');
        $query = Business::where('business_name', 'LIKE', '%' . $request->cari . '%')->limit(5)->get();

        if ($query) {
            $html = view('Ajax.Guest.search', ['business' => $query])->render();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'Get data success'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error ketika mencari lokasi'
            ]);
        }
    }
}
