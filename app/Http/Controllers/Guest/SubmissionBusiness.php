<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\BusinessSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmissionBusiness extends Controller
{
    public function form()
    {
        return view('Guest.submission');
    }

    public function process(Request $request)
    {
        $data = [
            'uuid' => Str::uuid()->toString(),
            'submiter_name' => $request->submiter_name,
            'submiter_phone_number' => $request->submiter_phone_number,
            'business_name' => $request->business_name,
            'business_description' => $request->business_description,
            'business_address' => $request->business_address,
        ];
        try {
            BusinessSubmission::create($data);
            return 'OK';
        } catch (\Exception $th) {
            return $th;
        }
    }
}