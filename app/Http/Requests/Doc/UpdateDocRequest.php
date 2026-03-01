<?php

namespace App\Http\Requests\Doc;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'min:5', 'max:160'],
            'content' => ['nullable', 'string', 'min:30'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'status' => ['nullable', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
