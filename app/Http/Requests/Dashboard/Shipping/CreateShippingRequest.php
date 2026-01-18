<?php
namespace App\Http\Requests\Dashboard\Shipping;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateShippingRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'province'           => 'nullable|string|max:255',
            'district'           => 'nullable|string|max:255',
            'local_level'       => 'nullable|json',
            'estimated_delivery' => 'nullable|date',
            'method'             => ['nullable', Rule::in(['standard', 'express', 'urgent'])],
            'notes'              => 'nullable|string',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors'  => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
