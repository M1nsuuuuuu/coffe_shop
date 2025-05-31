@extends('layouts.admin')

@section('title', 'Добавить пользователя')

@section('content')
<div class="admin-header">
    <h1>Добавить пользователя</h1>
</div>

<div class="admin-form">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
            @error('phone')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Почта</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection