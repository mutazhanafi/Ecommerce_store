<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductStoreRequest extends FormRequest
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
        $rules=[
            'slug'=>'required|unique:products,slug',
            'brand_id'=>'sometimes|nullable|numeric|exists:brands,id',
            'category'=>'required|array|min:1',
            'category.*'=>'numeric|exists:categories,id',
            'tag'=>'sometimes|nullable|array',
            'price'=>'numeric|required',
            'special_price'=>'nullable|numeric',
            'special_price_type'=>'sometimes|nullable|required_with:special_price|in:fixed,percent',
            'special_price_start'=>'sometimes|nullable|required_with:special_price|date|after_or_equal:today',
            'special_price_end'=>'sometimes|nullable|required_with:special_price|date|after_or_equal:special_price_start',
            'selling_price'=>'numeric|required',
            'sku'=>'required',
            'qty'=>'numeric|required'
        ];
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $rules += [$localeCode . '.name' => 'required|max:180|unique:product_translations,name'];
        }
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $rules += [$localeCode . '.description' => 'required'];
        }
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {
            $rules += [$localeCode . '.short_description' => 'sometimes|nullable'];
        }

        return $rules;
    }
}
