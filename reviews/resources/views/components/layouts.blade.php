<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Отзывы городов'}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-vh-100 d-flex flex-column">

<div id="preloader" class="d-none position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
     style="background:rgba(255,255,255,.6);z-index:9999">
    <div class="spinner-border text-warning" role="status"></div>
</div>

<x-layouts.header/>
<main class="flex-grow-1">
    <div class="container">
        {{$slot}}
    </div>
</main>
<x-layouts.footer/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmFXFMrWm8xNZpUIUors9Ghfb+c" crossorigin="anonymous"></script>
</body>
</html>
