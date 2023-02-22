<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
        </div>
        <img src="{{ Storage::url($product->image) }}" alt="Изображение {{ Storage::url($product->name) }}" height="240px">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }} ₽</p>
            <br>
            <p>Категория: {{ $product->category->name }}</p>
            <form action="{{ route('basket-add', $product) }}" method="POST">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                <a href="{{ route('product', [$product->category->code, $product->code]) }}" class="btn btn-default"
                    role="button">Подробнее</a>
                <input type="hidden" name="_token">
                @csrf
            </form>
            <p></p>
        </div>
    </div>
</div>
