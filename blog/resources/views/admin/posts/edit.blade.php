<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать пост</h2>
    </x-slot>

    @include('admin.posts.partials.form', ['action' => route('admin.posts.update', $post), 'method' => 'PUT', 'post' => $post])
</x-app-layout>
