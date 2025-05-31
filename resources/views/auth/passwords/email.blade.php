@extends('layouts.app')

@section('styles')
<style>
    body {
        background-image: url('{{ asset('images/auth-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .header, .footer {
        display: none;
    }
    
    .main-content {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <!-- Изменяем ссылку на крестике, чтобы она вела на страницу входа -->
    <a href="{{ route('login') }}" class="close-btn">&times;</a>
    
    <div class="auth-form">
        <h1>Сброс пароля</h1>
        
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Отправить ссылку для сброса пароля</button>
            </div>
            
            <div class="form-group text-center">
                <p>Вспомнили пароль? <a href="{{ route('login') }}">Войти</a></p>
            </div>
        </form>
    </div>
</div>
@endsection