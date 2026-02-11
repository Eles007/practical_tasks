<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$post->title}}</title>
</head>
<body>
    <div>
        <a href="{{ route("posts.index") }}">Назад к постам</a>

        <div>
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->published_at?->format('d.m.Y')}}</p>
        </div>

        <div>{!! nl2br(e($post->body)) !!}</div>
    </div>
</body>
</html>
