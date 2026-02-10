<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Управление постами</h2>
            <a href="{{ route('admin.posts.create') }}" class="text-indigo-600 hover:underline">Создать пост</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-md">{{ session('success') }}</div>
                @endif

                @forelse($posts as $post)
                    <div class="border-b pb-3">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold">{{ $post->title }}</p>
                                <p class="text-sm text-gray-500">Статус: {{ $post->status }} · Комментариев: {{ $post->comments_count }}</p>
                            </div>

                            <div class="flex gap-3 text-sm">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-600 hover:underline">Открыть</a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:underline">Редактировать</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Удалить пост?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline" type="submit">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Постов нет.</p>
                @endforelse

                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
