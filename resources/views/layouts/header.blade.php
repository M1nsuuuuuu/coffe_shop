<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Главная</a></li>
                    <li><a href="{{ url('/menu') }}" class="{{ request()->is('menu*') ? 'active' : '' }}">Меню</a></li>
                    <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">О нас</a></li>
                    <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Контакты</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <!-- Обновленная структура для иконки корзины -->
                <a href="#" id="cart-icon" class="cart-icon-container">
                    <img src="{{ asset('images/icons/cart.png') }}" alt="Cart" class="cart-icon">
                    <span class="cart-text">Корзина</span>
                </a>
                
                @guest
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/icons/user.png') }}" alt="User">
                    </a>
                @else
                    <a href="{{ route('profile') }}">
                        <img src="{{ asset('images/icons/user.png') }}" alt="User">
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>