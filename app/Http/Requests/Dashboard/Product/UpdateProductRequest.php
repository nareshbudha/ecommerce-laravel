<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set to true to allow validation
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the current product ID from the route
        $productId = $this->route('product')->id ?? null;

        return [
            'name' => 'nullable|max:100',
            'slug' => [
                'nullable',
                'max:100',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => [
                'nullable',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'quantity' => 'nullable|numeric',
            'stock' => 'nullable|boolean',
            'coupons_id' => 'nullable|numeric',
            'featured' => 'nullable|boolean',
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
}
