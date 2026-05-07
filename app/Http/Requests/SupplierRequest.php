<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy id nhà cung cấp khi update
        $supplierId = $this->route('supplier')?->id_ncc;

        return [
            'ten_ncc' => 'required|unique:nha_cung_cap,ten_ncc,' . $supplierId . ',id_ncc',
            'dia_chi' => 'required',
            'sdt'     => 'required|unique:nha_cung_cap,sdt,' . $supplierId . ',id_ncc',
            'email'   => 'required|email|unique:nha_cung_cap,email,' . $supplierId . ',id_ncc',
            'ghi_chu' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'ten_ncc.required' => 'Tên nhà cung cấp không được để trống',
            'ten_ncc.unique'   => 'Tên nhà cung cấp đã tồn tại',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'sdt.required'     => 'Số điện thoại không được để trống',
            'sdt.unique'       => 'Số điện thoại đã tồn tại',
            'email.required'   => 'Email không được để trống',
            'email.email'      => 'Email không đúng định dạng',
            'email.unique'     => 'Email đã tồn tại',
            'ghi_chu.required' => 'Ghi chú không được để trống',
            'ghi_chu.string'   => 'Ghi chú phải là chuỗi ký tự',
            'ghi_chu.max'      => 'Ghi chú không được vượt quá 255 ký tự',
        ];
    }
}
