<?php

namespace App\Http\Controllers\Admin\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Edit extends Controller
{
    public function form(Request $request)
    {
        $business = Business::where('uuid', $request->uuid)->first();
        abort_if(!$business, 404);

        return view('Admin.Business.edit', [
            'title' => 'Edit Usaha | E-Parking',
            'data' => $business
        ]);
    }

    public function process(Request $request)
    {
        $business = Business::where('uuid', $request->uuid)->first();

        $data = [
            'business_name' => $request->business_name,
            'business_thumbnail' => $business->business_thumbnail,
            'business_description' => $request->business_description,
            'business_address' => $request->business_address,
            'status' => $request->status,
        ];

        if ($request->hasFile('business_thumbnail')) {
            $move = $request->file('business_thumbnail')->storeAs('business-thumbnail', Str::slug($request->business_name));

            if (!$move) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload foto');
            }

            $data['business_thumbnail'] = $move;
        }

        try {
            Business::where('uuid', $request->uuid)->update($data);
            return redirect()->to(route('Admin.Business.All'))->with('success', 'Berhasil memperbarui data ' . $data['business_name']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ' . $data['business_name'] . ' ' . $e);
        }
    }
}
