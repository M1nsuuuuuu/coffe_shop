@extends('layouts.admin')

@section('title', 'Редактировать товар')

@section('content')
<div class="admin-header">
    <h1>Редактировать товар</h1>
</div>

<div class="admin-form">
    <form method="POST" action="{{ route('admin.products.update', $drink->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $drink->name) }}" required>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $drink->description) }}</textarea>
            @error('description')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Текущее изображение</label>
            <div class="current-image">
                <img src="{{ asset('storage/' . $drink->image) }}" alt="{{ $drink->name }}">
            </div>
        </div>
        
        <div class="form-group">
            <label for="image">Новое изображение (оставьте пустым, чтобы сохранить текущее)</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Объемы и цены</label>
            <div id="volumes-container">
                @foreach($drink->volumes as $index => $volume)
                <div class="volume-row">
                    <input type="text" name="volumes[]" value="{{ $volume }}" class="form-control" required>
                    <input type="number" name="prices[]" value="{{ $drink->prices[$index] }}" class="form-control" min="0" step="1" required>
                    <button type="button" class="remove-volume-btn">Удалить</button>
                </div>
                @endforeach
            </div>
            <button type="button" id="add-volume-btn" class="btn btn-secondary">Добавить объем</button>
        </div>
        
        <div class="form-group">
            <label>Группы</label>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="is_hit" value="1" {{ old('is_hit', $drink->is_hit) ? 'checked' : '' }}>
                    Хит
                </label>
                <label>
                    <input type="checkbox" name="is_new" value="1" {{ old('is_new', $drink->is_new) ? 'checked' : '' }}>
                    Новинка
                </label>
                <label>
                    <input type="checkbox" name="is_discount" value="1" {{ old('is_discount', $drink->is_discount) ? 'checked' : '' }}>
                    Выгодно
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
    
    <form method="POST" action="{{ route('admin.products.delete', $drink->id) }}" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить товар</button>
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