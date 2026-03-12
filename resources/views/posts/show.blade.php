@extends('layouts.app')

@section('title', 'Блог на Laravel 12')

@section('content')
    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col gap-4 bg-gray-900/40 p-6 rounded-2xl">
            <div>
                <a
                    href="{{ route('blog.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-sm text-gray-300 hover:text-white"
                >
                    ← Ко всем постам
                </a>
            </div>

            <article class="prose prose-invert max-w-none">
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    Опубликовано: {{ optional($post->published_at ?? $post->created_at)->format('d.m.Y') }}
                </p>

                @if($post->tags->isNotEmpty())
                    <div class="not-prose mt-3 flex flex-wrap gap-2">
                        @foreach($post->tags as $t)
                            <a
                                href="{{ route('blog.tags.show', $t->slug) }}"
                                class="inline-flex items-center rounded-full border border-white/10 bg-gray-950/40 px-2.5 py-1 text-xs text-gray-300 hover:text-white hover:border-white/20 transition"
                            >
                                #{{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($post->image)
                    <div class="w-full">
                        <img src="{{$post->image_url}}" alt="{{$post->title}}" class="w-full rounded">
                    </div>
                @endif
                <h1 class="mb-4 text-3xl font-bold">
                    {{ $post->title }}
                </h1>

                <div class="mt-6">
                    {!! $post->body !!}
                </div>
            </article>

            <section class="mt-6 border-t border-white/10 pt-6">
                <h2 class="text-lg font-semibold">Комментарии</h2>

                @if (session('status'))
                    <div class="mt-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form
                    action="{{ route('blog.comments.store', $post->slug) }}"
                    method="POST"
                    class="mt-4 space-y-3"
                >
                    @csrf

                    @guest
                        <div>
                            <label class="block text-sm text-gray-300">Имя</label>
                            <input
                                name="author_name"
                                value="{{ old('author_name') }}"
                                class="mt-1 w-full rounded-lg border border-white/10 bg-gray-900/40 px-3 py-2 text-sm text-gray-200 placeholder-gray-500 focus:border-fuchsia-500/50 focus:outline-none"
                                placeholder="Как к вам обращаться?"
                            >
                            @error('author_name') <p class="mt-1 text-sm text-red-400">{{$message}}</p> @enderror
                        </div>
                    @endguest

                    <div>
                        <label class="block text-sm text-gray-300">Комментарий</label>
                        <textarea
                            name="body"
                            rows="4"
                            class="mt-1 w-full rounded-lg border border-white/10 bg-gray-900/40 px-3 py-2 text-sm text-gray-200 placeholder-gray-500 focus:border-fuchsia-500/50 focus:outline-none"
                            placeholder="Напишите ваш комментарий..."
                        >{{ old('body') }}</textarea>
                        @error('body') <p class="mt-1 text-sm text-red-400">{{$message}}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button
                            class="rounded-lg border border-fuchsia-500/30 bg-fuchsia-500/10 px-3 py-2 text-sm text-fuchsia-300 transition hover:bg-fuchsia-500/20 hover:text-white"
                            type="submit"
                        >
                            Отправить
                        </button>
                    </div>
                </form>

                <div class="mt-6 space-y-4">
                    @forelse($comments as $comment)
                        <div class="rounded-2xl border border-white/10 bg-gray-950/30 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-white">
                                    {{ $comment->user?->name ?? $comment->author_name ?? 'Аноним' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $comment->created_at->format('d.m.Y H:i') }}
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-200 whitespace-pre-wrap">
                                {{ $comment->body }}
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400">
                            Пока нет комментариев — вы можете быть первым.
                        </div>
                    @endforelse
                </div>

                @if($comments->hasPages())
                    <div class="mt-4">
                        {{ $comments->onEachSide(1)->links('components.pagination') }}
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection
