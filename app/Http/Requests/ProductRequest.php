<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy id sản phẩm khi update
        $productId = $this->route('product')?->id_san_pham;

        $rules = [
            'ten_san_pham'   => 'required|unique:san_pham,ten_san_pham,' . $productId . ',id_san_pham',
            'id_danh_muc'    => 'required',
            'id_thuong_hieu' => 'required',
            'id_ncc'         => 'required',
            'hinh_anh'       => 'nullable|image',
            'km_phan_tram'   => 'nullable|numeric|min:0|max:100',
            'trang_thai'     => 'boolean'
        ];

        if ($this->input('trang_thai') == 1) {
            $rules['mo_ta']    = 'required';
            $rules['gia_ban']  = 'required|numeric|min:0';
        } else {
            $rules['gia_ban']  = 'nullable|numeric|min:0';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm không được để trống',
            'ten_san_pham.unique'   => 'Tên sản phẩm đã tồn tại',
            'id_danh_muc.required'  => 'Vui lòng chọn danh mục',
            'id_thuong_hieu.required' => 'Vui lòng chọn thương hiệu',
            'id_ncc.required'       => 'Vui lòng chọn nhà cung cấp',
            'hinh_anh.image'        => 'Hình ảnh phải là một tệp hình ảnh hợp lệ',
            'gia_ban.required'      => 'Khi sản phẩm đang bán, giá bán bắt buộc phải nhập',
            'gia_ban.numeric'       => 'Giá bán phải là số',
            'gia_ban.min'           => 'Giá bán phải lớn hơn hoặc bằng 0',
            'km_phan_tram.numeric'  => 'Khuyến mãi phải là số',
            'km_phan_tram.min'      => 'Khuyến mãi không được nhỏ hơn 0%',
            'km_phan_tram.max'      => 'Khuyến mãi không được vượt quá 100%',
            'mo_ta.required'        => 'Khi sản phẩm đang bán, mô tả bắt buộc phải nhập',
            'trang_thai.boolean'    => 'Trạng thái phải là true/false',
        ];
    }
}
