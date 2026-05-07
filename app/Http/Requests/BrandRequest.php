<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Lấy id thương hiệu khi update
        $brandId = $this->route('brand')?->id_thuong_hieu;

        return [
            'ten_thuong_hieu' => 'required|unique:thuong_hieu,ten_thuong_hieu,' . $brandId . ',id_thuong_hieu',
            'quoc_gia'        => 'required',
            'logo'            => 'nullable',
            'logo_file'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'ten_thuong_hieu.required' => 'Tên thương hiệu không được để trống',
            'ten_thuong_hieu.unique'   => 'Tên thương hiệu đã tồn tại',
            'quoc_gia.required'        => 'Quốc gia không được để trống',
            'logo_file.image'          => 'Logo phải là một tệp hình ảnh',
            'logo_file.mimes'          => 'Logo chỉ chấp nhận định dạng: jpg, jpeg, png, gif, webp',
            'logo_file.max'            => 'Logo không được vượt quá 2MB',
        ];
    }
}
