<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'content' => ['required', 'string', 'min:3'],
        ];
    }
}
