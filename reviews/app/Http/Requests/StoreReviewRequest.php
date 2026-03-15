<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'cities' => 'nullable|array',
            'cities.*' => 'string|max:100',
        ];
    }
}
