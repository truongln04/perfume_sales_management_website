<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Danh sách tài khoản
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('ten_hien_thi', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $accounts = $query->get();

        return view('admin.accounts.index', compact('accounts'));
    }

    // Trang thêm
    public function create()
    {
        return view('admin.accounts.create');
    }

    // Lưu thêm mới
    public function store(AccountRequest $request)
    {
        User::create([
            'ten_hien_thi' => $request->ten_hien_thi,
            'email'        => $request->email,
            'sdt'          => $request->sdt,
            'google_id'    => $request->google_id,
            'anh_dai_dien' => $request->anh_dai_dien,
            'mat_khau'     => Hash::make($request->mat_khau),
            'vai_tro'      => $request->vai_tro,
        ]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Thêm tài khoản thành công!');
    }

    // Trang sửa
    public function edit(User $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    // Cập nhật
    public function update(AccountRequest $request, User $account)
    {
        $account->ten_hien_thi = $request->ten_hien_thi;
        $account->email        = $request->email;
        $account->sdt          = $request->sdt;
        $account->google_id    = $request->google_id;
        $account->anh_dai_dien = $request->anh_dai_dien;
        $account->vai_tro      = $request->vai_tro;

        if ($request->mat_khau) {
            $account->mat_khau = Hash::make($request->mat_khau);
        }

        $account->save();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Cập nhật tài khoản thành công!');
    }

    // Xóa
    public function destroy(User $account)
    {
        // Kiểm tra nếu tài khoản có đơn hàng liên quan
        if ($account->orders()->count() > 0) {
            return redirect()
                ->route('admin.accounts.index')
                ->with('error', 'Không thể xóa tài khoản vì đang có đơn hàng liên quan!');
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Xóa tài khoản thành công!');
    }

    // Search riêng nếu cần API
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $accounts = User::where('ten_hien_thi', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->get();

        return view('admin.accounts.index', compact('accounts'));
    }
}
