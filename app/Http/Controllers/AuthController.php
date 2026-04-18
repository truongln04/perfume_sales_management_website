<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;
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
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        $request->validate([
            'ten_hien_thi' => 'required|string|max:255',
            'email'        => 'required|email|unique:tai_khoan,email',
            'password'     => 'required|min:6|confirmed',
            'sdt'          => 'nullable|digits:10',
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
     * Đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email'    => trim($request->email),
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower(trim($user->vai_tro));

            if (in_array($role, ['admin', 'nhanvien'])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Đăng nhập quản trị thành công!');
            }

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

    /* ==================================================
                QUÊN MẬT KHẨU BẰNG SESSION OTP
    ================================================== */

    /**
     * Form nhập email
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi OTP
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:tai_khoan,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.exists'   => 'Email không tồn tại'
        ]);

        $lastSent = session('otp_last_sent');

        if ($lastSent && now()->diffInSeconds($lastSent) < 30) {
            return back()->with('error', 'Vui lòng đợi 30 giây để gửi lại mã.');
        }

        $code = rand(100000, 999999);

        session([
            'reset_email'   => $request->email,
            'reset_code'    => $code,
            'reset_expire'  => now()->addMinutes(10),
            'otp_last_sent' => now()
        ]);

        Mail::raw("Mã OTP đặt lại mật khẩu của bạn là: $code", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Quên mật khẩu - Mã OTP');
        });

        return redirect()->route('password.reset.form')
            ->with('success', 'Đã gửi mã OTP đến email!');
    }

    /**
     * Form nhập OTP + mật khẩu mới
     */
    public function showResetPasswordForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', [
            'email' => session('reset_email')
        ]);
    }

    /**
     * Xác nhận OTP và đổi mật khẩu
     */
    public function confirmResetPassword(Request $request)
    {
        $request->validate([
            'code'                  => 'required',
            'password'              => 'required|min:6|confirmed',
        ], [
            'code.required'         => 'Vui lòng nhập mã OTP',
            'password.required'     => 'Vui lòng nhập mật khẩu mới',
            'password.confirmed'    => 'Xác nhận mật khẩu không khớp',
        ]);

        if (!session()->has('reset_code')) {
            return back()->with('error', 'Vui lòng yêu cầu mã mới.');
        }

        if (now()->gt(session('reset_expire'))) {
            session()->forget([
                'reset_email',
                'reset_code',
                'reset_expire',
                'otp_last_sent'
            ]);

            return back()->with('error', 'Mã OTP đã hết hạn.');
        }

        if ($request->code != session('reset_code')) {
            return back()->with('error', 'Mã OTP không đúng.');
        }

        User::where('email', session('reset_email'))->update([
            'mat_khau' => Hash::make($request->password)
        ]);

        session()->forget([
            'reset_email',
            'reset_code',
            'reset_expire',
            'otp_last_sent'
        ]);

        return redirect()->route('login')
            ->with('success', 'Đổi mật khẩu thành công!');
    }

    /**
     * Gửi lại OTP
     */
    public function resendOtp()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        $lastSent = session('otp_last_sent');

        if ($lastSent && now()->diffInSeconds($lastSent) < 30) {
            return back()->with('error', 'Vui lòng đợi 30 giây để gửi lại mã.');
        }

        $code = rand(100000, 999999);

        session([
            'reset_code'    => $code,
            'reset_expire'  => now()->addMinutes(10),
            'otp_last_sent' => now()
        ]);

        Mail::raw("Mã OTP mới của bạn là: $code", function ($message) {
            $message->to(session('reset_email'))
                    ->subject('Gửi lại mã OTP');
        });

        return back()->with('success', 'Đã gửi lại mã OTP!');
    }

    /**
 * Chuyển hướng đến Google
 */
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

/**
 * Google callback
 */
public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->email)->first();

        // Nếu đã tồn tại tài khoản
        if ($user) {

            // Chỉ cho khách hàng login Google
            if (strtoupper(trim($user->vai_tro)) !== 'KHACHHANG') {
                return redirect()->route('login')
                    ->with('error', 'Tài khoản quản trị không được đăng nhập bằng Google.');
            }

            // cập nhật google_id nếu chưa có
            if (!$user->google_id) {
                $user->google_id = $googleUser->id;
                $user->anh_dai_dien = $googleUser->avatar;
                $user->save();
            }

        } else {

            // Tạo mới tài khoản khách hàng
            $user = User::create([
                'ten_hien_thi' => $googleUser->name,
                'email'        => $googleUser->email,
                'google_id'    => $googleUser->id,
                'anh_dai_dien' => $googleUser->avatar,
                'mat_khau'     => Hash::make(uniqid()),
                'vai_tro'      => 'KHACHHANG',
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Đăng nhập Google thành công!');
    } catch (Exception $e) {
        return redirect()->route('login')
            ->with('error', 'Đăng nhập Google thất bại.');
    }
}
}