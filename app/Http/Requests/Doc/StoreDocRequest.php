<?php

namespace App\Http\Requests\Doc;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:5', 'max:160'],
            'content' => ['required', 'string', 'min:30'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'status' => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'max:20480'],
        ];
    }
}
