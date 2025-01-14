<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'sale_price' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'quantity' => ['required', 'integer'],
            'sku' => ['required', 'string'],
            'ribon' => ['required', 'string'],
            'productOptions' => ['required', 'json'],
        ];
    }
}
