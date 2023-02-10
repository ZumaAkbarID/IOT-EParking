<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Settings extends Controller
{
    public function form()
    {
        return view('Auth.settings', [
            'title' => 'Pengaturan Akun | E-Parking',
        ]);
    }

    public function process(Request $request)
    {
        $user = User::where('uuid', $request->uuid)->first();
        abort_if(!$user, 404);

        $this->validate(
            $request,
            [
                'phone_number' => 'numeric|min:9'
            ],
            [
                'password.numeric' => 'Nomor HP hanya boleh mengandung angka',
                'phone_number.min' => 'Nomor HP minimal 9 angka',
            ]
        );

        $data = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ];

        if (!is_null($request->password)) {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:6'
                ],
                [
                    'password.required' => 'Password dibutuhkan',
                    'password.min' => 'Password minimal 6 karakter',
                ]
            );

            $data['password'] = Hash::make($request->password);
        }

        try {
            User::where('uuid', $request->uuid)->update($data);
            return redirect()->back()->with('success', 'Akun berhasil diperbarui. ' . (!is_null($request->password)) ? 'Password diperbarui' : '');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Akun gagal diperbarui. ' . $e);
        }
    }
}
