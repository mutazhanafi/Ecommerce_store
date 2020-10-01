<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'photo' => 'required_without:id|mimes:jpg,jpeg,png'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('admin/brands.name.required') ,

            'photo.required' => __('admin/brands.photo.required'),

        ];
    }
}
