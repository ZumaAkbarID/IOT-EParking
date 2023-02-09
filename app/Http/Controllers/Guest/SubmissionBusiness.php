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
        return view('Guest.submission', [
            'title' => 'Pengajuan Usaha | E-Parking'
        ]);
    }

    public function process(Request $request)
    {
        $this->validate(
            $request,
            [
                'submiter_phone_number' => 'unique:business_submissions,submiter_phone_number|numeric',
                'business_name' => 'unique:business_submissions,business_name',
                'business_thumbnail' => 'image|mimes:png,jpg,jpeg,gif|dimensions:width=640,height=427'
            ],
            [
                'submiter_phone_number.unique' => 'Nomor HP sudah terdaftar',
                'submiter_phone_number.numeric' => 'Nomor HP hanya boleh mengandung angka',
                'business_name.unique' => 'Usaha sudah terdaftar',
                'business_thumbnail.image' => 'Foto usaha tidak valid',
                'business_thumbnail.mimes' => 'Ekstensi foto hanya bisa .png, .jpg, .jpeg, .gif',
                'business_thumbnail.dimensions' => 'Ukuran foto harus 640x427'
            ]
        );

        $data = [
            'uuid' => Str::uuid()->toString(),
            'submiter_name' => $request->submiter_name,
            'submiter_phone_number' => $request->submiter_phone_number,
            'business_name' => $request->business_name,
            'business_description' => $request->business_description,
            'business_address' => $request->business_address,
        ];

        $move = $request->file('business_thumbnail')->storeAs('business-thumbnail', Str::slug($request->business_name));

        if (!$move) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupload foto');
        }
        $data['business_thumbnail'] = $move;

        try {
            BusinessSubmission::create($data);

            return redirect()->back()->with('success', 'Berhasil mengirim pengajuan, kami akan menghubungi Anda');
        } catch (\Exception $th) {
            return redirect()->back()->withInput()->with('error', $th);
        }
    }
}