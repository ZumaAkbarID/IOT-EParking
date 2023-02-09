<?php

namespace App\Http\Controllers\Guest;

use App\Events\ParkiranUpdate;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Machine;
use App\Models\Parking;
use Illuminate\Http\Request;

class Main extends Controller
{
    public function index(Request $request)
    {
        if ($request->uuid) {

            $data = [
                'total' => 0,
                'used' => 0,
            ];

            $business = Business::where('uuid', $request->uuid)->first();
            $machines = Machine::where('business_uuid', $request->uuid)->get();
            $parkings = Parking::where('business_uuid', $request->uuid)->get();

            foreach ($parkings as $parking) {
                $data['used_' . $parking->machine_uuid] = 0;
                $arrayMap = json_decode($parking->map, true);
                for ($i = 1; $i <= count($arrayMap); $i++) {
                    $data['used_' . $parking->machine_uuid] += $arrayMap['place_' . $i];
                }
            }

            foreach ($machines as $machine) {
                $data['total'] += $machine->total_sensor;
            }

            return view('Guest.info', [
                'title' => $business->business_name . ' | E-Parking',
                'place' => $business->business_name,
                'uuid' => $business->uuid,
                'machines' => $machines,
                'available' => rand(0, 10),
                'data' => $data,
            ]);
        }

        return view('Guest.landing', [
            'title' => 'E-Parking',
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

    public function table(Request $request)
    {
        abort_if(!$request->ajax(), 403, 'Akses ditolak');
        $query = Parking::where('business_uuid', $request->uuid)->where('machine_uuid', $request->machine_id)->first();

        if ($query) {
            $html = view('Ajax.Guest.table', ['parking' => $query])->render();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => 'Get data success'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error ketika mengambil data '
            ]);
        }
    }
}