@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
<div class="auth-form">
    <h2>Упс, не верный пароль!</h2>
    <p>Хотите изменить пароль?</p>
    
    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        
        <div class="form-group">
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Номер телефона" value="{{ old('phone') }}" required>
            @error('phone')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Новый пароль" required>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Повторите пароль" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Изменить</button>
        </div>
    </form>
</div>
@endsection