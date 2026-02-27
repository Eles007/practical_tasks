<nav class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <x-application-logo class="h-9 w-auto text-gray-800"/>
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">

                @guest

                    <!-- Login -->
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 rounded-xl
                   text-gray-600 hover:text-gray-900
                   hover:bg-gray-100 transition">
                        Вход
                    </a>

                    <!-- Register -->
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 rounded-xl
                   bg-green-600 text-gray-600
                   hover:bg-green-700 transition">
                        Регистрация
                    </a>

                @endguest


                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 hover:bg-gray-100">
                        Профиль
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="w-full text-left px-4 py-2
                                    hover:bg-gray-100">
                            Выйти
                        </button>
                    </form>

                @endauth

            </div>

        </div>
    </div>

</nav>
