<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-md">{{ session('success') }}</div>
            @endif

            <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">{{ $post->created_at?->format('d.m.Y H:i') }} · {{ $post->user?->name }}</p>

                @if($post->tags->isNotEmpty())
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="prose max-w-none mt-4">{!! nl2br(e($post->content)) !!}</div>
            </article>

            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Комментарии ({{ $post->approvedComments->count() }})</h3>
                @forelse($post->approvedComments as $comment)
                    <div class="border-b py-3">
                        <p class="font-medium">{{ $comment->author }}</p>
                        <p class="text-sm text-gray-400">{{ $comment->created_at?->format('d.m.Y H:i') }}</p>
                        <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">Комментариев пока нет.</p>
                @endforelse

                <form action="{{ route('comments.store', $post->slug) }}" method="post" class="mt-6 space-y-3">
                    @csrf
                    <div>
                        <x-input-label for="author" value="Имя" />
                        <x-text-input id="author" name="author" class="block mt-1 w-full" :value="old('author')" required />
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" type="email" name="email" class="block mt-1 w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="url" value="Сайт (необязательно)" />
                        <x-text-input id="url" name="url" class="block mt-1 w-full" :value="old('url')" />
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="content" value="Комментарий" />
                        <textarea id="content" name="content" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="4" required>{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    <x-primary-button>Отправить</x-primary-button>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
