<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Кофейня</title>
    <link href="https://fonts.googleapis.com/css2?family=JejuGothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart-mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-fixes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-mobile-fixes.css') }}">
    @yield('styles')
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="header-left">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Логотип">
                    </div>
                    <div class="address-dropdown">
                        <span>Адрес</span>
                        <div class="dropdown-content">
                            <a href="#">ул. Революции 125/7</a>
                            <a href="#">ул. Лазурная 84</a>
                            <a href="#">ул. Лермонтова 12</a>
                        </div>
                    </div>
                </div>
                
                <nav class="main-nav">
                    <ul>
                        <li>
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/icons/all.png') }}" alt="Все">
                                </div>
                                <span>Всё</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hits') }}" class="{{ request()->routeIs('hits') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/icons/hits.png') }}" alt="Хиты">
                                </div>
                                <span>Хиты</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="disabled">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/icons/constructor.png') }}" alt="Конструктор">
                                </div>
                                <span>Конструктор</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('new') }}" class="{{ request()->routeIs('new') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/icons/new.png') }}" alt="Новинки">
                                </div>
                                <span>Новинки</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('discounts') }}" class="{{ request()->routeIs('discounts') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/icons/discounts.png') }}" alt="Скидки">
                                </div>
                                <span>Скидки</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <div class="header-right">
                    <div class="cart-icon" id="cart-icon">
                        <img src="{{ asset('images/icons/cart.png') }}" alt="Корзина">
                        <span>Корзина</span>
                    </div>
                    <div class="profile">
                        <a href="{{ Auth::check() ? route('profile') : route('login') }}">
                            <div class="avatar">
                                @if(Auth::check())
                                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @else
                                    <img src="{{ asset('images/icons/user.png') }}" alt="Профиль">
                                @endif
                            </div>
                            <span>Профиль</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Логотип">
                </div>
                <div class="footer-info">
                    <p>Сеть кофеен All Rights Reserved. © 2024-2025</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-header">
            <span id="cart-count">0 товаров на 0₽</span>
            <button class="close-cart" id="close-cart">&times;</button>
        </div>
        <div class="cart-items" id="cart-items">
            <!-- Cart items will be loaded here -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Сумма заказа:</span>
                <span id="cart-total-price">0₽</span>
            </div>
            <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="delivery_address" value="ул. Революции 125/7">
                <button type="submit" class="checkout-btn">Заказать</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>