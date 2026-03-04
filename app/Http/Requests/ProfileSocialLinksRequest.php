<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSocialLinksRequest extends FormRequest
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
            'socialLinks' => 'required|string|max:800',
        ];
    }

    public function messages()
    {
        return [
            'socialLinks.required' => 'Social links is required',
            'socialLinks.string' => 'Social links must be a string',
            'socialLinks.max' => 'Social links must be less than 800 characters',
        ];
    }
}
