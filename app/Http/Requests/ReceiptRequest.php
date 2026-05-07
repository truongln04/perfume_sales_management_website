<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Phiếu nhập
            'id_ncc'     => 'required|exists:nha_cung_cap,id_ncc',
            'ngay_nhap'  => 'required|date',
            'ghi_chu'    => 'nullable|string|max:255',

            // Chi tiết phiếu nhập
            'details'                => 'required|array|min:1',
            'details.*.id_san_pham'  => 'required|exists:san_pham,id_san_pham',
            'details.*.so_luong'     => 'required|integer|min:1',
            'details.*.don_gia'      => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'id_ncc.required'             => 'Vui lòng chọn nhà cung cấp',
            'id_ncc.exists'               => 'Nhà cung cấp không hợp lệ',
            'ngay_nhap.required'          => 'Ngày nhập không được để trống',
            'ngay_nhap.date'              => 'Ngày nhập phải đúng định dạng ngày',
            'ghi_chu.string'              => 'Ghi chú phải là chuỗi ký tự',
            'ghi_chu.max'                 => 'Ghi chú không được vượt quá 255 ký tự',

            'details.required'            => 'Phiếu nhập phải có ít nhất một chi tiết',
            'details.array'               => 'Chi tiết phiếu nhập phải là mảng',
            'details.min'                 => 'Phiếu nhập phải có ít nhất một sản phẩm',

            'details.*.id_san_pham.required' => 'Vui lòng chọn sản phẩm',
            'details.*.id_san_pham.exists'   => 'Sản phẩm không hợp lệ',
            'details.*.so_luong.required'    => 'Số lượng không được để trống',
            'details.*.so_luong.integer'     => 'Số lượng phải là số nguyên',
            'details.*.so_luong.min'         => 'Số lượng phải lớn hơn 0',
            'details.*.don_gia.required'     => 'Đơn giá không được để trống',
            'details.*.don_gia.numeric'      => 'Đơn giá phải là số',
            'details.*.don_gia.min'          => 'Đơn giá phải lớn hơn hoặc bằng 0',
        ];
    }
}
