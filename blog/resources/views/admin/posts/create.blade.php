<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать пост</h2>
    </x-slot>

    @include('admin.posts.partials.form', ['action' => route('admin.posts.store'), 'method' => 'POST', 'post' => null])
</x-app-layout>
