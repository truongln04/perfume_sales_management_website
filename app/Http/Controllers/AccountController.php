<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Danh sách tài khoản
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
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
    public function store(Request $request)
    {
        $request->validate([
            'ten_hien_thi' => 'required|string|max:100',
        'email'        => 'required|email|unique:tai_khoan,email',
        'mat_khau'     => 'required|min:6',
        'vai_tro'      => 'required',
        ]);

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
    public function edit($id)
    {
        $account = User::findOrFail($id);
        return view('admin.accounts.edit', compact('account'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $account = User::findOrFail($id);

        $request->validate([
            'ten_hien_thi'     => 'required|string|max:100',
            'email'    => 'required|email|unique:tai_khoan,email,' . $id . ',id_tai_khoan',
        ]);

        $account->ten_hien_thi = $request->ten_hien_thi;
        $account->email = $request->email;
        $account->sdt = $request->sdt;
        $account->google_id = $request->google_id;
        $account->anh_dai_dien = $request->anh_dai_dien;
        $account->vai_tro = $request->vai_tro;

        if ($request->mat_khau) {
            $account->password = Hash::make($request->mat_khau);
        }

        $account->save();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Cập nhật tài khoản thành công!');
    }

    // Xóa
    public function destroy($id)
    {
        $account = User::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Xóa tài khoản thành công!');
    }

    // Search riêng nếu cần API
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $accounts = User::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->get();

        return view('admin.accounts.index', compact('accounts'));
    }
}