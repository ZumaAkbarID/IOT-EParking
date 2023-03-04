<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;

class Delete extends Controller
{
    public function destroy(Request $request)
    {
        $checkMachine = Machine::where('uuid', $request->uuid)->first();

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
