<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Посты</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-lg font-semibold text-indigo-600 hover:underline">
                        {{ $post->title }}
                    </a>
                    <p class="text-sm text-gray-500 mt-2">{{ $post->created_at?->format('d.m.Y') }}</p>
                    <p class="mt-3 text-gray-700">{{ \Illuminate\Support\Str::limit($post->content, 180) }}</p>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-600">
                    Постов пока нет.
                </div>
            @endforelse

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
