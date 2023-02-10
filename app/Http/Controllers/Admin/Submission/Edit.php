<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Edit extends Controller
{
    public function form(Request $request)
    {
        $submission = BusinessSubmission::where('uuid', $request->uuid)->first();
        abort_if(!$submission, 404);

        return view('Admin.Submission.edit', [
            'title' => 'Edit Pengajuan | E-Parking',
            'data' => $submission
        ]);
    }

    public function process(Request $request)
    {
        $submission = BusinessSubmission::where('uuid', $request->uuid)->first();

        $data = [
            'submiter_name' => $request->submiter_name,
            'submiter_phone_number' => $request->submiter_phone_number,
            'business_name' => $request->business_name,
            'business_thumbnail' => $submission->business_thumbnail,
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

        if ($request->status == 'rejected') {
            $data['reject_reason'] = $request->reject_reason;
        } else {
            $data['reject_reason'] = null;

            $insert = [
                'submission_uuid' => $request->uuid,
                'uuid' => Str::uuid()->toString(),
                'business_name' => $request->business_name,
                'business_thumbnail' => $data['business_thumbnail'],
                'business_description' => $request->business_description,
                'business_address' => $request->business_address,
                'status' => 'non-aktif'
            ];
            try {
                try {
                    User::create([
                        'uuid' => Str::uuid()->toString(),
                        'name' => $request->submiter_name,
                        'phone_number' => $request->submiter_phone_number,
                        'role' => 'Pengurus',
                        'business_uuid' => $insert['uuid'],
                        'password' => Hash::make('parkiranku')
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error', 'Gagal membuat akun usaha ' . $data['business_name'] . ' ' . $e);
                }

                Business::create($insert);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal membuat data usaha ' . $data['business_name'] . ' ' . $e);
            }
        }

        try {
            BusinessSubmission::where('uuid', $request->uuid)->update($data);
            return redirect()->to(route('Admin.Submission'))->with('success', 'Berhasil memperbarui data ' . $data['business_name']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ' . $data['business_name'] . ' ' . $e);
        }
    }
}
