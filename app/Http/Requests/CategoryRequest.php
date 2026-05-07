<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy id danh mục khi update
        $categoryId = $this->route('category')?->id_danh_muc;

        return [
            'ten_danh_muc' => 'required|string|max:255|unique:danh_muc,ten_danh_muc,' . $categoryId . ',id_danh_muc',
            'mo_ta'        => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'ten_danh_muc.required' => 'Tên danh mục không được để trống',
            'ten_danh_muc.string'   => 'Tên danh mục phải là chuỗi ký tự',
            'ten_danh_muc.max'      => 'Tên danh mục không được vượt quá 255 ký tự',
            'ten_danh_muc.unique'   => 'Tên danh mục đã tồn tại',
            'mo_ta.string'          => 'Mô tả phải là chuỗi ký tự',
        ];
    }
}
