<?php

namespace App\Http\Controllers\Pengurus\Machine;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class View extends Controller
{
    public function index()
    {
        $machine = Machine::where('business_uuid', Auth::user()->business_uuid)->get();

        $data = [
            'machine' => $machine,
            'totalSensor' => 0,
        ];
        foreach ($machine as $item) {
            $data['totalSensor'] += $item->total_sensor;
        }

        return view('Pengurus.Machine.view', [
            'title' => 'Mesin | E-Parking',
            'data' => $data
        ]);
    }
}
