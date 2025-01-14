<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'banner_background' => ['required', 'string'],
            'banner_title' => ['required', 'string'],
            'banner_image' => ['required', 'string'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'icons' => ['required', 'json'],
        ];
    }
}
