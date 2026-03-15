<x-layouts title="Регистрация">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-5">
            <div class="mb-4">
                <h2 class="fw-bold">Регистрация</h2>
                <p class="text-muted">Уже есть аккаунт? <a href="{{ route('login') }}" class="text-warning fw-semibold text-decoration-none">Войти</a></p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ФИО</label>
                            <input type="text" name="fio" class="form-control @error('fio') is-invalid @enderror"
                                   value="{{ old('fio') }}" placeholder="Иванов Иван Иванович" required>
                            @error('fio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="example@mail.ru" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Телефон</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="+7 (999) 999-99-99" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Пароль</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Минимум 8 символов" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Повторите пароль</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Сколько будет {{ session('captcha_question') }}?
                            </label>
                            <input type="number" name="captcha"
                                   class="form-control @error('captcha') is-invalid @enderror"
                                   placeholder="Введите ответ" required>
                            @error('captcha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts>
