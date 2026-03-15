<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MathCaptcha;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerForm()
    {
        $a = rand(1, 10);
        $b = rand(1, 10);
        session(['captcha_answer' => $a + $b, 'captcha_question' => "{$a} + {$b}"]);

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fio'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'captcha'  => ['required', 'integer', new MathCaptcha],
        ], [
            'captcha.required' => 'Введите ответ на проверочный вопрос.',
            'captcha.integer'  => 'Ответ должен быть числом.',
        ]);

        $user = User::create([
            'fio'      => $request->fio,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        session()->forget(['captcha_answer', 'captcha_question']);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Регистрация прошла успешно! Проверьте email для подтверждения.');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && is_null($user->email_verified_at)) {
            return back()->withErrors(['email' => 'Сначала подтвердите email.'])->with('unverified_email', $request->email);
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Неверный email или пароль.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('cities'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->email), $hash)) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email уже подтверждён.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', 'Email подтверждён! Теперь вы можете войти.');
    }

    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Письмо отправлено повторно.');
    }
}
