@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile-favorites.css') }}">
@endsection

@section('content')
<div class="profile-container">
    
    <div class="profile-content">
        <div class="profile-section">
            <h2>Личные данные</h2>
            
            <div class="profile-info">
                <div class="info-item">
                    <label>Имя</label>
                    <p>{{ $user->name }}</p>
                </div>
                
                <div class="info-item">
                    <label>Номер телефона</label>
                    <p>{{ $user->phone }}</p>
                </div>
                
                <div class="info-item">
                    <label>Почта</label>
                    <p>{{ $user->email }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Выйти из аккаунта</button>
                </form>
            </div>
        </div>
        
        <div class="profile-section">
            <h2>История заказов</h2>
            
            <div class="orders-list">
                @forelse($orders as $order)
                <div class="order-item">
                    <div class="order-header">
                        <span>Заказ #{{ $order->id }}</span>
                        <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        <span>{{ $order->total_price }}₽</span>
                    </div>
                    
                    <div class="order-drinks">
                        @foreach($order->drinks as $drink)
                        <div class="order-drink">
                            <img src="{{ asset('storage/' . $drink->image) }}" alt="{{ $drink->name }}">
                            <div class="order-drink-info">
                                <h4>{{ $drink->name }}</h4>
                                <p>Объем: {{ $drink->pivot->volume }}</p>
                                <p>{{ $drink->pivot->price }}₽ x {{ $drink->pivot->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <p>У вас пока нет заказов</p>
                @endforelse
            </div>
        </div>
        
        <div class="profile-section">
            <h2>Сохраненные напитки</h2>
            
            <div class="favorites-list">
                @forelse($favorites as $drink)
                <a href="{{ route('drinks.show', $drink->id) }}" class="favorite-item">
                    <div class="favorite-badge" data-drink-id="{{ $drink->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFC300" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </div>
                    <img src="{{ asset('storage/' . $drink->image) }}" alt="{{ $drink->name }}">
                    <div class="favorite-info">
                        <h4>{{ $drink->name }}</h4>
                        <p>{{ $drink->description }}</p>
                        <p>от {{ $drink->prices[0] }}₽</p>
                    </div>
                </a>
                @empty
                <p>У вас пока нет сохраненных напитков</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
