<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|min:3',
            'tags' => ['nullable', 'string', 'max:500'],
            'excerpt' => 'required|min:10',
            'body' => 'required|min:10',
            'is_published' => 'sometimes|boolean',
            'is_approved' => 'sometimes|boolean',
            'published_at' => 'nullable',
            'user_id' => 'nullable',
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'remove_image' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Пожалуйста, введите заголовок',
            'excerpt.required' => 'Пожалуйста, введите короткое превью',
            'body.required' => 'Пожалуйста, введите текст поста',
            'image.image' => 'Файл должен быть изображением',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'is_approved' => $this->boolean('is_approved'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }
}
