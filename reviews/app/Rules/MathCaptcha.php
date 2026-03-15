<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MathCaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((int) $value !== (int) session('captcha_answer')) {
            $fail('Неверный ответ на проверочный вопрос.');
        }
    }
}
