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
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Новый пароль</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password-confirm">Подтверждение пароля</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сбросить пароль</button>
            </div>
        </form>
    </div>
</div>
@endsection