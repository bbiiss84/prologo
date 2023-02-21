<x-layout>
    <x-slot name='title'>
        Товар
    </x-slot>
    <h1>{{ $product->name }}</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }}</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{ $product->description }}</p>

    @if ($product->isAvailable())
        <a class="btn btn-success" href="{{ route('basket-add') }}">Добавить в корзину</a>
    @else
        <a class="btn btn-success" href="{{ route('basket-add') }}">Заказать</a>
    @endif
</x-layout>
