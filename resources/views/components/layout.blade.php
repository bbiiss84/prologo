<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <link href="/css/starter-template.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('index') }}">Интернет Магазин</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ route('index') }}">Все товары</a></li>
                    <li><a href="{{ route('categories') }}">Категории</a>
                    </li>
                    <li><a href={{ route('basket') }}>Корзина</a></li>
                    {{-- <li><a href="{{ route('index') }}">Сбросить проект в начальное состояние</a></li>
                    <li><a href="/locale/en">en</a></li> --}}

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">₽<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/currency/RUB">₽</a></li>
                            <li><a href="/currency/USD">$</a></li>
                            <li><a href="/currency/EUR">€</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @guest
                        <li><a href="{{ route('login') }}">Войти</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                    @endguest
                    @auth
                        <li><a href="{{ route('home') }}">Панель администратора</li>
                        <li><a href="{{ route('get-logout') }}">Выйти</li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="starter-template">
            @if (session()->has('success'))
                <!-- Если есть флаг 'success' -->
                <p class="alert alert-success">{{ session()->get('success') }}</p>
            @endif
            @if (session()->has('warning'))
                <p class="alert alert-warning">{{ session()->get('warning') }}</p>
            @endif
            {{ $slot }}
        </div>
    </div>
</body>

</html>
