<?php

namespace App\Http\Controllers\Admin\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;

class View extends Controller
{
    public function all(Request $request)
    {
        $business = [];
        $business['aktif'] = Business::where('status', 'aktif')->get();
        $business['non-aktif'] = Business::where('status', 'non-aktif')->get();

        return view('Admin.Business.all', [
            'title' => 'List Usaha | E-Parking',
            'data' => $business,
            'account' => User::where('role', 'Pengurus')->get()
        ]);
    }
}
