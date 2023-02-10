<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Machine;
use Illuminate\Http\Request;

class Edit extends Controller
{
    public function form(Request $request)
    {
        $machine = Machine::where('uuid', $request->uuid)->first();
        $business = Business::where('uuid', $machine->business_uuid)->first();
        abort_if(!$business, 404);

        return view('Admin.Machine.edit', [
            'title' => 'Edit Mesin | E-Parking',
            'business' => $business,
            'data' => $machine
        ]);
    }

    public function process(Request $request)
    {
        $machine = Machine::where('uuid', $request->uuid)->first();
        $business = Business::where('uuid', $request->business_uuid)->first();
        abort_if(!$business, 404);
        abort_if(!$machine, 404);

        $data = [
            'machine_name' => $request->machine_name,
            'total_sensor' => $request->total_sensor,
            'price_each_sensor' => $request->price_each_sensor,
        ];

        try {
            Machine::where('uuid', $machine->uuid)->update($data);
            return redirect()->to(route('Admin.Machine.View', $request->business_uuid))->with('success', 'Mesin berhasil diperbarui. Pastikan mesin sudah dites');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mesin gagal diperbarui. ' . $e);
        }
    }
}
