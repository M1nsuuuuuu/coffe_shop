document.addEventListener('DOMContentLoaded', function() {
    // Edit Group Modal
    const modal = document.getElementById('edit-group-modal');
    const btn = document.getElementById('edit-group-btn');
    const closeBtn = document.querySelector('.close-modal');
    
    if (btn && modal) {
        btn.addEventListener('click', function() {
            modal.style.display = 'flex';
        });
    }
    
    if (closeBtn && modal) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    // Edit Group Form
    const editGroupForm = document.getElementById('edit-group-form');
    if (editGroupForm) {
        editGroupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const drinkIdSelect = this.querySelector('select[name="drink_id"]');
            const drinkId = drinkIdSelect ? drinkIdSelect.value : null;
            
            if (!drinkId) {
                alert('Выберите товар');
                return;
            }
            
            const formData = new FormData(this);
            
            fetch('/admin/products/' + drinkId, {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Произошла ошибка: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Группа товара успешно изменена');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                    location.reload();
                })
                .catch(error => {
                    alert('Произошла ошибка: ' + error.message);
                });
        });
    }
    
    // Table Row Click
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            const drinkId = this.dataset.id;
            if (drinkId) {
                window.location.href = '/admin/products/' + drinkId + '/edit';
            }
        });
    });
    
    // Add Volume
    const addVolumeBtn = document.getElementById('add-volume-btn');
    const volumesContainer = document.getElementById('volumes-container');
    
    if (addVolumeBtn && volumesContainer) {
        addVolumeBtn.addEventListener('click', function() {
            const volumeRow = document.createElement('div');
            volumeRow.className = 'volume-row';
            volumeRow.innerHTML = `
                <input type="text" name="volumes[]" placeholder="Объем (например, 0.3л)" class="form-control" required>
                <input type="number" name="prices[]" placeholder="Цена" class="form-control" min="0" step="1" required>
                <button type="button" class="remove-volume-btn">Удалить</button>
            `;
            
            volumesContainer.appendChild(volumeRow);
            
            // Add event listener to the new remove button
            const removeBtn = volumeRow.querySelector('.remove-volume-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    volumeRow.remove();
                });
            }
        });
    }
    
    // Remove Volume (for existing buttons)
    const removeVolumeBtns = document.querySelectorAll('.remove-volume-btn');
    removeVolumeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const volumeRow = this.closest('.volume-row');
            if (volumeRow) {
                volumeRow.remove();
            }
        });
    });
});