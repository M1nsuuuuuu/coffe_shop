@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile-favorites.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <a href="{{ url('/') }}" class="close-btn">&times;</a>
    
    <div class="profile-header">
        <h1>Личный кабинет</h1>
        <div class="user-info">
            <div class="user-avatar">
                <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="user-details">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                @if(Auth::user()->phone)
                    <p>{{ Auth::user()->phone }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="profile-content">
        <!-- Favorites Section -->
        <div class="profile-section favorites">
            <h2>Сохранённые напитки</h2>
            <div class="favorites-list">
                @forelse($favorites as $favorite)
                    <a href="{{ route('drinks.show', $favorite->drink->id) }}" class="favorite-item">
                        <div class="favorite-badge" data-drink-id="{{ $favorite->drink->id }}">
                            <img src="{{ asset('images/icons/heart-filled.png') }}" alt="Удалить из избранного">
                        </div>
                        <img class="drink-image" src="{{ asset($favorite->drink->image) }}" alt="{{ $favorite->drink->name }}">
                        <div class="favorite-info">
                            <h4>{{ $favorite->drink->name }}</h4>
                            <p>{{ Str::limit($favorite->drink->description, 50) }}</p>
                            <div class="favorite-price">{{ $favorite->drink->price }} ₽</div>
                        </div>
                    </a>
                @empty
                    <p class="empty-message">У вас пока нет сохранённых напитков</p>
                @endforelse
            </div>
        </div>
        
        <!-- Orders Section -->
        <div class="profile-section orders">
            <h2>История заказов</h2>
            <div class="orders-list">
                @forelse($orders as $order)
                    <div class="order-item">
                        <div class="order-header">
                            <span>Заказ #{{ $order->id }}</span>
                            <span>Дата: {{ $order->created_at->format('d.m.Y H:i') }}</span>
                            <span>Статус: {{ $order->status }}</span>
                            <span>Сумма: {{ $order->total_price }} ₽</span>
                        </div>
                        <div class="order-drinks">
                            @foreach($order->items as $item)
                                <div class="order-drink">
                                    <img src="{{ asset($item->drink->image) }}" alt="{{ $item->drink->name }}">
                                    <div class="order-drink-info">
                                        <h4>{{ $item->drink->name }}</h4>
                                        <p>{{ $item->quantity }} x {{ $item->price }} ₽</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="empty-message">У вас пока нет заказов</p>
                @endforelse
            </div>
        </div>
        
        <!-- Settings Section -->
        <div class="profile-section settings">
            <h2>Настройки</h2>
            <form class="settings-form" method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                </div>
                <button type="submit" class="btn-save">Сохранить</button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Выйти</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
