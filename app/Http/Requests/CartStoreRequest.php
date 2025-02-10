<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'grand_total' => 'decimal:2',
            'user_id' => 'exists:users,id',
            'sub_total' => 'decimal:2',
            'discount' => 'decimal:2',
            'count' => 'integer',
        ];
    }
}
