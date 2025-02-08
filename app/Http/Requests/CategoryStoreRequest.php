<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'image' => ['required', 'image'],
            'description' => ['required', 'string'],
            // 'parent_id' => ['exists:categories,id'],
            'collection_id' => ['required', 'string'],
        ];
    }
}
