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
    
    @media screen and (max-width: 767px) {
        .auth-form {
            width: 90%;
            max-width: 350px;
        }
        
        .auth-form h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .btn-link {
            font-size: 14px;
            padding: 0;
            margin-left: 10px;
        }
    }
</style>

@section('content')
<div class="auth-container">
    <a href="{{ url('/') }}" class="close-btn">&times;</a>
    
    <div class="auth-form">
        <h1>Вход</h1>
        
        <form method="POST" action="{{ route('login') }}">
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
                <label for="password">Пароль</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Войти</button>
                
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">Забыли пароль?</a>
                @endif
            </div>
            
            <div class="form-group text-center">
                <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
            </div>
        </form>
    </div>
</div>


@endsection