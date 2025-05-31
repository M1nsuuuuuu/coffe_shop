@extends('layouts.admin')

@section('title', 'Пользователи')

@section('content')
<div class="admin-header">
    <h1>Пользователи</h1>
    
    <div class="admin-actions">
        <a href="{{ route('admin.users.create') }}" class="admin-btn add-btn">
            <span>+</span>
            <div class="btn-label">Добавить пользователя</div>
        </a>
        
        <a href="#" class="admin-btn export-btn">
            <span>↓</span>
            <div class="btn-label">Экспорт журнала</div>
        </a>
    </div>
</div>

<div class="admin-table">
    <div class="table-header">
        <div class="table-cell">Аватар</div>
        <div class="table-cell">Имя</div>
        <div class="table-cell">Номер</div>
        <div class="table-cell">Пароль</div>
    </div>
    
    <div class="table-body">
        @foreach($users as $user)
        <div class="table-row">
            <div class="table-cell">
                <div class="user-avatar">
                    <span>{{ substr($user->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="table-cell">{{ $user->name }}</div>
            <div class="table-cell">{{ $user->phone }}</div>
            <div class="table-cell">********</div>
        </div>
        @endforeach
    </div>
</div>
@endsection