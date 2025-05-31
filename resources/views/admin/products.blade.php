@extends('layouts.admin')

@section('title', 'Товары')

@section('content')
<div class="admin-header">
    <h1>Товары</h1>
    
    <div class="admin-actions">
        <a href="{{ route('admin.products.create') }}" class="admin-btn add-btn">
            <span>+</span>
            <div class="btn-label">Добавить товар</div>
        </a>
        
        <button class="admin-btn edit-btn" id="edit-group-btn">
            <span>?</span>
            <div class="btn-label">Изменить группу</div>
        </button>
        
        <a href="#" class="admin-btn export-btn">
            <span>↓</span>
            <div class="btn-label">Экспорт журнала</div>
        </a>
    </div>
</div>

<div class="admin-table">
    <div class="table-header">
        <div class="table-cell">Фото</div>
        <div class="table-cell">Название</div>
        <div class="table-cell">Цена</div>
        <div class="table-cell">Описание</div>
    </div>
    
    <div class="table-body">
        @foreach($drinks as $drink)
        <div class="table-row" data-id="{{ $drink->id }}">
            <div class="table-cell">
                <img src="{{ asset('storage/' . $drink->image) }}" alt="{{ $drink->name }}" class="product-image">
            </div>
            <div class="table-cell">{{ $drink->name }}</div>
            <div class="table-cell">от {{ $drink->prices[0] }}₽</div>
            <div class="table-cell">{{ $drink->description }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Edit Group Modal -->
<div class="modal" id="edit-group-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Изменить группу товара</h2>
        
        <form id="edit-group-form" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Выберите товар:</label>
                <select name="drink_id" required>
                    <option value="">-- Выберите товар --</option>
                    @foreach($drinks as $drink)
                    <option value="{{ $drink->id }}">{{ $drink->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Группы:</label>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" name="is_hit" value="1">
                        Хит
                    </label>
                    <label>
                        <input type="checkbox" name="is_new" value="1">
                        Новинка
                    </label>
                    <label>
                        <input type="checkbox" name="is_discount" value="1">
                        Выгодно
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Edit Group Modal
        const modal = $('#edit-group-modal');
        const btn = $('#edit-group-btn');
        const closeBtn = $('.close-modal');
        
        btn.click(function() {
            modal.show();
        });
        
        closeBtn.click(function() {
            modal.hide();
        });
        
        $(window).click(function(event) {
            if ($(event.target).is(modal)) {
                modal.hide();
            }
        });
        
        // Edit Group Form
        $('#edit-group-form').submit(function(e) {
            e.preventDefault();
            
            const drinkId = $('select[name="drink_id"]').val();
            if (!drinkId) {
                alert('Выберите товар');
                return;
            }
            
            const formData = $(this).serialize();
            
            $.ajax({
                url: '/admin/products/' + drinkId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert('Группа товара успешно изменена');
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    alert('Произошла ошибка: ' + xhr.responseText);
                }
            });
        });
        
        // Table Row Click
        $('.table-row').click(function() {
            const drinkId = $(this).data('id');
            window.location.href = '/admin/products/' + drinkId + '/edit';
        });
    });
</script>
@endsection