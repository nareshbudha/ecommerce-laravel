<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'short_description' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // main image
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => 'nullable|string|unique:products,sku',
            'stock' => 'required|boolean',
            'discount_coupon' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'hot_deals' => 'nullable|boolean',
            'new_arrivals' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string',
            'variants.*.color' => 'required|string',
            'variants.*.quantity' => 'required|numeric|min:0',
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
            'quantity' => 'nullable|numeric',

        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
