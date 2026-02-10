<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Комментарии</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                @forelse($comments as $comment)
                    <div class="border-b pb-4">
                        <p class="font-semibold">{{ $comment->author }} ({{ $comment->email }})</p>
                        <p class="text-sm text-gray-500">Пост: {{ $comment->post?->title }}</p>
                        <p class="mt-2">{{ $comment->content }}</p>
                        <div class="flex gap-4 mt-3">
                            @if($comment->status !== 'approved')
                                <form method="post" action="{{ route('admin.comments.approve', $comment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-green-600 hover:underline" type="submit">Одобрить</button>
                                </form>
                            @endif
                            <form method="post" action="{{ route('admin.comments.destroy', $comment) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" type="submit">Удалить</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Комментариев нет.</p>
                @endforelse

                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
