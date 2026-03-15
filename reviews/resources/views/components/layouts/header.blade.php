<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <a href="/" class="text-white text-decoration-none fs-4 me-4">Reviews</a>
            <ul class="nav mx-auto text-center">
                <li><a href="/cities" class="nav-link px-2 text-white">Отзывы городов</a></li>
            </ul>
            <div class="text-end d-flex align-items-center gap-2">
                @auth
                    <span class="text-white-50 small d-none d-lg-inline">{{ auth()->user()->fio }}</span>
                    <a href="{{ route('reviews.create') }}" class="btn btn-warning btn-sm fw-semibold">+ Отзыв</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Зарегистрироваться</a>
                @endauth
            </div>
        </div>
    </div>
</header>
