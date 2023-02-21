<x-layout>
    <x-slot name='title'>
        Категории
    </x-slot>
    @foreach ($categories as $category)
        <div class="panel">
            <a href="{{ route('category', $category->code) }}">
                <img src="/storage/categories/mobile.jpg">
                <h2>{{ $category->name }}</h2>
            </a>
            <p>
                {{ $category->description }}
            </p>
        </div>
    @endforeach
</x-layout>
