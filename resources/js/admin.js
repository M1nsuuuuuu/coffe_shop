import $ from 'jquery';
window.$ = window.jQuery = $;

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
    
    // Add CSRF Token to AJAX Requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});