<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Machine;
use Illuminate\Http\Request;

class View extends Controller
{
    public function view(Request $request)
    {
        $business = Business::where('uuid', $request->uuid)->first();
        abort_if(!$business, 404);

        $machine = Machine::where('business_uuid', $request->uuid)->get();
        $data = [
            'machine' => $machine,
            'totalSensor' => 0,
        ];
        foreach ($machine as $item) {
            $data['totalSensor'] += $item->total_sensor;
        }


        return view('Admin.Machine.view', [
            'title' => 'Mesin ' . $business->business_name . ' | E-Parking',
            'data' => $data,
            'business' => $business
        ]);
    }
}
