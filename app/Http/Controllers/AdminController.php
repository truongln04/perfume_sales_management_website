<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function profile()
    {
        return view('admin.profile');
    }

    public function editProfile()
    {
        return view('admin.profile-edit');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ten_hien_thi' => 'required|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('tai_khoan', 'email')
                    ->ignore($user->id_tai_khoan, 'id_tai_khoan')
            ],

            'sdt' => 'nullable|digits:10',

            'mat_khau' => 'nullable|min:6',

            // validate file
        'avatar_file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
        

        $data = [
            'ten_hien_thi' => $request->ten_hien_thi,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'anh_dai_dien' => $request->anh_dai_dien,
        ];

         // ✅ Ưu tiên upload file nếu có
    if ($request->hasFile('avatar_file')) {
        $file = $request->file('avatar_file');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('images'), $filename);

        $data['anh_dai_dien'] = $filename;
    }

        // Nếu có đổi mật khẩu
        if ($request->filled('mat_khau')) {
            $data['mat_khau'] = Hash::make($request->mat_khau);
        }

        $user->update($data);

        return back()->with('success', 'Cập nhật thành công!');
    }
}