<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;


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

     public function dashboard()
    {
        // Đếm số tài khoản
        $taiKhoan = User::count();

        // Đếm số sản phẩm
        $sanPham = Product::count();

        // Đơn hàng mới (chờ xác nhận)
        $donHangMoi = Order::where('trang_thai', Order::STATUS_CHO_XAC_NHAN)->count();

        // Doanh thu: tổng tiền của đơn hàng đã thanh toán
        $doanhThu = Order::where('trang_thai_tt', Order::PAYMENT_STATUS_DA_THANH_TOAN)->sum('tong_tien');

        return view('admin.dashboard', compact('taiKhoan','sanPham','donHangMoi','doanhThu'));
    }
}