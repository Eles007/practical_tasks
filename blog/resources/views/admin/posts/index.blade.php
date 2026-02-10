<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Мои посты</h2>
            <a href="{{ route('admin.posts.create') }}" class="text-indigo-600 hover:underline">Создать пост</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                @forelse($posts as $post)
                    <div class="border-b pb-3">
                        <p class="font-semibold">{{ $post->title }}</p>
                        <p class="text-sm text-gray-500">{{ $post->status }}</p>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:underline">Редактировать</a>
                    </div>
                @empty
                    <p class="text-gray-600">Постов нет.</p>
                @endforelse

                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
