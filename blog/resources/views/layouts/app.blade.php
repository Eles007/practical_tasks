<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
<nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
        <a href="{{ route('posts.index') }}" class="font-bold">
            Laravel Blog
        </a>

        <div class="space-x-4">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 py-6 flex gap-6">
    <div class="w-3/4">
        @yield('content')
    </div>

    <aside class="w-1/4">
        @yield('sidebar')
    </aside>
</main>
</body>
</html>
