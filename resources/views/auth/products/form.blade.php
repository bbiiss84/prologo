<x-master>

    @isset($product)
        <x-slot name='title'>
            Редактировать товар {{ $product->name }}
        </x-slot>
    @else
        <x-slot name='title'>
            Создать товар
        </x-slot>
    @endisset

    <div class="col-md-12">
        @isset($product)
            <h1>Редактировать товар <b>{{ $product->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
            @isset($product) action="{{ route('products.update', $product) }}" @else action="{{ route('products.store') }}" @endisset>
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'code'])
                        <input type="text" class="form-control" name="code" id="code"
                            value="{{ old('code', isset($product) ? $product->code : null) }}">

                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'name'])
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', isset($product) ? $product->name : null) }}">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @isset($product)
                                        @if ($product->category_id == $category->id)
                                            selected
                                        @endif
                                    @endisset>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'description'])
                        <textarea name="description" id="description" cols="72" rows="7">
                            {{ old('description', isset($product) ? $product->description : null) }}
                        </textarea>

                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-default btn-file">
                            Загрузить <input type="file" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="price" class="col-sm-6 col-form-label">Цена: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'price'])
                        <input type="text" class="form-control" name="price" id="price"
                            value="{{ old('price', isset($product) ? $product->price : null) }}">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="count" class="col-sm-4 col-form-label">Количество: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'count'])
                        <input type="text" class="form-control" name="count" id="count"
                            value="{{ old('count', isset($product) ? $product->count : null) }}">
                    </div>
                </div>
                <br>
            </div>
            <br>
            @foreach (['hit' => 'Хит', 'new' => 'Новинка', 'recommend' => 'Рекомендуемые'] as $field => $title)
                <div class="form-group row">
                    <label for="code" class="col-sm-2 col-form-label">{{ $title }}: </label>
                    <div class="col-sm-1">
                        <input type="checkbox" class="form-control" name="{{ $field }}"
                            id="{{ $field }}" @if (isset($product) && $product->$field === 1) checked = "checked" @endif>
                    </div>
                </div>
                <br>
            @endforeach
            <button class="btn btn-success">Сохранить</button>
    </div>
    </form>

    </div>
</x-master>
