<x-layouts title="Вход">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-5">
            <div class="mb-4">
                <h2 class="fw-bold">Вход</h2>
                <p class="text-muted">Нет аккаунта? <a href="{{ route('register') }}" class="text-warning fw-semibold text-decoration-none">Зарегистрироваться</a></p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Пароль</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-muted" for="remember">Запомнить меня</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Войти</button>
                    </form>

                    @if(session('unverified_email'))
                        <div class="mt-3 text-center">
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ session('unverified_email') }}">
                                <button type="submit" class="btn btn-link text-muted p-0 small">Отправить письмо повторно</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts>
