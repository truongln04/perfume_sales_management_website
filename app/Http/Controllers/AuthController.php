<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký tài khoản
     */
    public function register(Request $request)
    {
        $request->validate([
            'ten_hien_thi' => 'required|string|max:255',
            'email'        => 'required|email|unique:tai_khoan,email',
            'password'     => 'required|min:6|confirmed',
            'sdt'          => 'nullable|digits:10',
        ], [
            'ten_hien_thi.required' => 'Vui lòng nhập tên hiển thị',
            'email.required'        => 'Vui lòng nhập email',
            'email.email'           => 'Email không hợp lệ',
            'email.unique'          => 'Email đã tồn tại',
            'password.required'     => 'Vui lòng nhập mật khẩu',
            'password.min'          => 'Mật khẩu tối thiểu 6 ký tự',
            'password.confirmed'    => 'Xác nhận mật khẩu không khớp',
            'sdt.digits'            => 'Số điện thoại phải gồm 10 số',
        ]);

        User::create([
            'ten_hien_thi' => $request->ten_hien_thi,
            'email'        => $request->email,
            'sdt'          => $request->sdt,
            'mat_khau'     => Hash::make($request->password),
            'vai_tro'      => 'KHACHHANG',
        ]);

        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công!');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Vui lòng nhập email',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $credentials = [
            'email'    => trim($request->email),
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Chuẩn hóa vai trò từ DB (ADMIN / admin đều nhận)
            $role = strtolower(trim($user->vai_tro));

            // Admin / Nhân viên
            if (in_array($role, ['admin', 'nhanvien'])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Đăng nhập quản trị thành công!');
            }

            // Khách hàng
            return redirect()->intended('/')
                ->with('success', 'Đăng nhập thành công!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Sai email hoặc mật khẩu');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Đã đăng xuất');
    }
}