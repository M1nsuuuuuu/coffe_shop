@extends('layouts.admin')

@section('title', 'Добавить товар')

@section('content')
<div class="admin-header">
    <h1>Добавить товар</h1>
</div>

<div class="admin-form">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Изображение</label>
            <input type="file" name="image" id="image" class="form-control" required>
            @error('image')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Объемы и цены</label>
            <div id="volumes-container">
                <div class="volume-row">
                    <input type="text" name="volumes[]" placeholder="Объем (например, 0.3л)" class="form-control" required>
                    <input type="number" name="prices[]" placeholder="Цена" class="form-control" min="0" step="1" required>
                    <button type="button" class="remove-volume-btn">Удалить</button>
                </div>
            </div>
            <button type="button" id="add-volume-btn" class="btn btn-secondary">Добавить объем</button>
        </div>
        
        <div class="form-group">
            <label>Группы</label>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="is_hit" value="1" {{ old('is_hit') ? 'checked' : '' }}>
                    Хит
                </label>
                <label>
                    <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}>
                    Новинка
                </label>
                <label>
                    <input type="checkbox" name="is_discount" value="1" {{ old('is_discount') ? 'checked' : '' }}>
                    Выгодно
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add Volume
        $('#add-volume-btn').click(function() {
            const volumeRow = `
                <div class="volume-row">
                    <input type="text" name="volumes[]" placeholder="Объем (например, 0.3л)" class="form-control" required>
                    <input type="number" name="prices[]" placeholder="Цена" class="form-control" min="0" step="1" required>
                    <button type="button" class="remove-volume-btn">Удалить</button>
                </div>
            `;
            
            $('#volumes-container').append(volumeRow);
        });
        
        // Remove Volume
        $(document).on('click', '.remove-volume-btn', function() {
            $(this).closest('.volume-row').remove();
        });
    });
</script>
@endsection