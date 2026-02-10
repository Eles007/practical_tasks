<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ $action }}" method="post" class="space-y-4">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif

                <div>
                    <x-input-label for="title" value="Заголовок" />
                    <x-text-input id="title" name="title" class="block mt-1 w-full" :value="old('title', $post?->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="content" value="Текст" />
                    <textarea id="content" name="content" rows="8" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('content', $post?->content) }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" value="Статус" />
                    <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        @foreach(['draft' => 'Черновик', 'published' => 'Опубликован', 'archived' => 'Архив'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $post?->status ?? 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tags" value="Теги (через запятую)" />
                    <x-text-input id="tags" name="tags" class="block mt-1 w-full" :value="old('tags', $post?->tags?->pluck('name')->join(', '))" />
                    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                </div>

                <x-primary-button>Сохранить</x-primary-button>
            </form>
        </div>
    </div>
</div>
