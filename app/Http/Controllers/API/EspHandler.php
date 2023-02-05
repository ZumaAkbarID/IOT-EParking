<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EspHandler extends Controller
{
    public function store(Request $request)
    {
        $str = $request->getContent();

        if (substr_count($str, "#") !== 1) {
            Log::error('DATA MENUMPUK');
            return 1;
        }

        $str = str_replace("'", '"', $str);
        $str = substr($str, 1);
        $str = str_replace('#', '', $str);
        $parsedJson = json_decode($str, true);

        $txt = "API : {$parsedJson['api_key']}\nKUNCI MESIN : {$parsedJson['machine_key']}\nTERSEDIA : {$parsedJson['available']}\nTOTAL : {$parsedJson['inside']}\n\nTMPAT 1 : {$parsedJson['map']['place_1']}\nTMPAT 2 : {$parsedJson['map']['place_2']}\nTMPAT 3 : {$parsedJson['map']['place_3']}";

        Log::info($txt);
        return 1;
    }
}