<?php

namespace App\Http\Controllers\Pengurus\Machine;

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

        return view('Pengurus.Machine.edit', [
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
            'price_each_sensor' => $request->price_each_sensor,
        ];

        try {
            Machine::where('uuid', $machine->uuid)->update($data);
            return redirect()->to(route('Pengurus.Machine.All'))->with('success', 'Mesin berhasil diperbarui. Pastikan mesin sudah dites');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mesin gagal diperbarui. ' . $e);
        }
    }
}
