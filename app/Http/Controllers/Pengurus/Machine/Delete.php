<?php

namespace App\Http\Controllers\Pengurus\Machine;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Delete extends Controller
{
    public function destroy(Request $request)
    {
        $checkMachine = Machine::where('uuid', $request->uuid)->where('business_uuid', Auth::user()->business_uuid)->first();

        if (!$checkMachine) {
            return response()->json([
                'status' => false,
            ]);
        }

        try {
            Machine::where('id', $checkMachine->id)->delete();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
