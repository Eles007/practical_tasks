<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $authorRule = Auth::check()
            ? ['nullable', 'string', 'max:100']
            : ['required', 'string', 'max:100'];

        return [
            'author_name' => $authorRule,
            'body' => ['required', 'string', 'min:3', 'max:5000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_name' => is_string($this->author_name ?? null) ? trim($this->author_name) : $this->author_name,
            'body' => is_string($this->body ?? null) ? trim($this->body) : $this->body,
        ]);
    }
}

