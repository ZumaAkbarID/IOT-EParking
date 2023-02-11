<?php

namespace App\Http\Controllers\Pengurus\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Edit extends Controller
{
    public function form(Request $request)
    {
        $business = Business::where('uuid', Auth::user()->business_uuid)->first();
        abort_if(!$business, 404);

        return view('Pengurus.Business.edit', [
            'title' => 'Edit Usaha | E-Parking',
            'data' => $business
        ]);
    }

    public function process(Request $request)
    {
        $business = Business::where('uuid', Auth::user()->business_uuid)->first();
        abort_if(!$business, 404);

        $this->validate(
            $request,
            [
                'business_name' => 'unique:businesses,business_name,' . $business->id
            ],
            [
                'business_name.unique' => 'Nama usaha sudah digunakan'
            ]
        );

        $data = [
            'business_name' => $request->business_name,
            'business_thumbnail' => $business->business_thumbnail,
            'business_description' => $request->business_description,
            'business_address' => $request->business_address,
            'status' => $request->status,
        ];

        if ($request->hasFile('business_thumbnail')) {
            $move = $request->file('business_thumbnail')->storeAs('business-thumbnail', Str::slug($request->business_name) . '-' . time());

            if (!$move) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload foto');
            } else {
                Storage::delete($business->business_thumbnail);
            }

            $data['business_thumbnail'] = $move;
        }

        try {
            Business::where('uuid', $request->uuid)->update($data);
            return redirect()->to(route('Pengurus.Business.Edit'))->with('success', 'Berhasil memperbarui data ' . $data['business_name']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ' . $data['business_name'] . ' ' . $e);
        }
    }
}
