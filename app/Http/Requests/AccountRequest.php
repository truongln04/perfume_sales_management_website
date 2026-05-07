<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy id tài khoản khi update
        $accountId = $this->route('account')?->id_tai_khoan;

        return [
            'ten_hien_thi' => 'required|string|max:100',
            'email'        => 'required|email|unique:tai_khoan,email,' . $accountId . ',id_tai_khoan',
            'mat_khau'     => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            'vai_tro'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ten_hien_thi.required' => 'Tên hiển thị không được để trống',
            'ten_hien_thi.string'   => 'Tên hiển thị phải là chuỗi ký tự',
            'ten_hien_thi.max'      => 'Tên hiển thị không được vượt quá 100 ký tự',
            'email.required'        => 'Email không được để trống',
            'email.email'           => 'Email không đúng định dạng',
            'email.unique'          => 'Email đã tồn tại',
            'mat_khau.required'     => 'Mật khẩu không được để trống',
            'mat_khau.min'          => 'Mật khẩu phải có ít nhất 6 ký tự',
            'vai_tro.required'      => 'Vui lòng chọn vai trò',
        ];
    }
}
