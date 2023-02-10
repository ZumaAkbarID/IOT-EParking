<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Edit extends Controller
{
    public function form(Request $request)
    {
        if (strlen($request->uuid) < 30) {
            $user = User::where('phone_number', $request->uuid)->first();
        } else {
            $user = User::where('uuid', $request->uuid)->first();
        }
        abort_if(!$user, 404);

        return view('Admin.User.edit', [
            'title' => 'Edit User | E-Parking',
            'data' => $user
        ]);
    }

    public function process(Request $request)
    {
        $user = User::where('uuid', $request->uuid)->first();
        abort_if(!$user, 404);

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
            return redirect()->to(route('Admin.User.All'))->with('success', 'Akun berhasil diperbarui. ' . (!is_null($request->password)) ? 'Password diperbarui' : '');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Akun gagal diperbarui. ' . $e);
        }
    }
}
