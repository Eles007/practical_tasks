<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Блог</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                <form method="GET" action="{{ route('posts.index') }}" class="grid gap-3 md:grid-cols-[1fr_auto]">
                    <x-text-input name="q" :value="$search" placeholder="Поиск по заголовку или тексту" class="w-full" />
                    <x-primary-button class="justify-center">Найти</x-primary-button>
                </form>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('posts.index') }}" class="px-3 py-1 text-sm rounded-full {{ $activeTag ? 'bg-gray-100 text-gray-600' : 'bg-indigo-100 text-indigo-700' }}">Все</a>
                    @foreach($tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="px-3 py-1 text-sm rounded-full {{ $activeTag === $tag->name ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                            #{{ $tag->name }} ({{ $tag->frequency }})
                        </a>
                    @endforeach
                </div>
            </div>

            @forelse($posts as $post)
                <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-xl font-semibold text-indigo-600 hover:underline">
                        {{ $post->title }}
                    </a>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $post->created_at?->format('d.m.Y H:i') }} · Автор: {{ $post->user?->name }}
                    </p>

                    @if($post->tags->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <p class="mt-3 text-gray-700">{{ \Illuminate\Support\Str::limit($post->content, 220) }}</p>
                </article>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-600">
                    Посты по вашему запросу не найдены.
                </div>
            @endforelse

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
