<?php

namespace App\Http\Controllers\API;

use App\Events\ParkiranUpdate;
use App\Events\TotalMoneyPengurus;
use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Parking;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EspHandler extends Controller
{
    public function store(Request $request)
    {
        $str = $request->getContent();

        $str = str_replace("'", '"', $str);
        $str = substr($str, 1);
        $str = str_replace('#', '', $str);
        $parsedJson = json_decode($str, true);

        $countCrash = substr_count($request->getContent(), "#");
        if ($countCrash !== 1) {
            Log::error('DATA MENUMPUK');
            $errorData = [];
            $errorData['sender'] = $parsedJson['sender'];
            $errorData['business_id'] = $parsedJson['business_id'];
            $errorData['message'] = 'Terjadi penumpukan data';
            $errorJson = json_encode($errorData);

            event(new ParkiranUpdate($errorJson));
            Log::channel('errorAPI')->error($errorJson);
            return $countCrash;
        }

        $machine = Machine::where('uuid', $parsedJson['machine_id'])->where('business_uuid', $parsedJson['business_id'])->first();

        // ParkiranUpdate::dispatch($str);

        if ($parsedJson['sender'] == 'sensor') {
            event(new ParkiranUpdate($str));
        }

        if ($parsedJson['sender'] == 'sensor') {
            try {
                $checkParking = Parking::where('business_uuid', $parsedJson['business_id'])->where('machine_uuid', $parsedJson['machine_id'])->first();

                if (!empty($checkParking)) {
                    Parking::where('business_uuid', $parsedJson['business_id'])->where('machine_uuid', $parsedJson['machine_id'])->delete();

                    $input = Parking::create([
                        'business_uuid' => $parsedJson['business_id'],
                        'machine_uuid' => $parsedJson['machine_id'],
                        'map' => json_encode($parsedJson['map']),
                    ]);

                    Log::channel('parkedAPI')->info("Parking Inputed id : " . $input->id . ". Old Parking Deleted");
                } else {
                    $input = Parking::create([
                        'business_uuid' => $parsedJson['business_id'],
                        'machine_uuid' => $parsedJson['machine_id'],
                        'map' => json_encode($parsedJson['map']),
                    ]);
                    Log::channel('parkedAPI')->info("Parking Inputed id : " . $input->id);
                }

                return response()->json(['status' => true]);
            } catch (\Exception $e) {
                Log::channel('errorAPI')->error("Error When Inputing API Map to DB : " . $e);
                return response()->json(['status' => false]);
            }
        } else {
            try {

                if ($parsedJson['sender'] == 'gate_out') {
                    $gate_out = json_encode(['amount' => $machine->price_each_sensor, 'business_uuid' => $parsedJson['business_id']]);
                    event(new TotalMoneyPengurus($gate_out));
                }

                $insert = Report::create([
                    'business_uuid' => $parsedJson['business_id'],
                    'machine_uuid' => $parsedJson['machine_id'],
                    'gate' => $parsedJson['sender'],
                    'price_rate' => $machine->price_each_sensor
                ]);
                Log::channel('reportAPI')->info($parsedJson['sender'] . " ID : " . $insert->id);

                return response()->json(['status' => true]);
            } catch (\Exception $e) {
                Log::channel('reportErrorAPI')->error("Error Cuy, When Inputing API Gate to DB : " . $e);
                $gate_out = json_encode(['message' => "Gagal melakukan entry data gerbang", 'business_uuid' => $parsedJson['business_id']]);
                event(new TotalMoneyPengurus($gate_out));

                return response()->json(['status' => false]);
            }
        }

        $txt = "SENDER : {$parsedJson['sender']}\nID Usaha : {$parsedJson['business_id']}\nID MESIN : {$parsedJson['machine_id']}\n";

        Log::info($txt);
        return 1;
    }
}
