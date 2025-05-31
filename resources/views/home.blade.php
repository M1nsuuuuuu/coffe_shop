@extends('layouts.app')

@section('content')
<div class="container">
    <div class="drinks-grid">
        @foreach($drinks as $drink)
        <div class="drink-card">
            <a href="{{ route('drinks.show', $drink->id) }}">
                <div class="drink-image">
                    <img src="{{ asset('storage/' . $drink->image) }}" alt="{{ $drink->name }}">
                    @if($drink->is_hit)
                    <span class="badge hit">Хит</span>
                    @elseif($drink->is_new)
                    <span class="badge new">Новинка</span>
                    @elseif($drink->is_discount)
                    <span class="badge discount">Выгодно</span>
                    @endif
                </div>
            </a>
            <div class="drink-info">
                <h3 class="drink-name">{{ $drink->name }}</h3>
                <p class="drink-description">{{ $drink->description }}</p>
                <p class="drink-price">от {{ $drink->prices[0] }}₽</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection