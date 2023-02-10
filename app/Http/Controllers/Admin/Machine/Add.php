<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Add extends Controller
{
    public function form(Request $request)
    {
        $business = Business::where('uuid', $request->uuid)->first();
        abort_if(!$business, 404);

        return view('Admin.Machine.add', [
            'title' => 'Tambah Mesin | E-Parking',
            'business' => $business
        ]);
    }

    public function process(Request $request)
    {
        $business = Business::where('uuid', $request->uuid)->first();
        abort_if(!$business, 404);

        $data = [
            'uuid' => Str::uuid()->toString(),
            'business_uuid' => $request->uuid,
            'machine_name' => $request->machine_name,
            'total_sensor' => $request->total_sensor,
            'price_each_sensor' => $request->price_each_sensor,
        ];

        try {
            Machine::create($data);
            return redirect()->to(route('Admin.Machine.View', $request->uuid))->with('success', 'Mesin berhasil didaftarkan. Silahkan menghubungi Admin untuk request mesin & melakukan testing');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mesin gagal didaftarkan. ' . $e);
        }
    }
}
