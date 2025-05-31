document.addEventListener('DOMContentLoaded', function() {
    // Cart Sidebar
    const cartIcon = document.getElementById('cart-icon');
    const cartSidebar = document.getElementById('cart-sidebar');
    const closeCart = document.getElementById('close-cart');

    if (cartIcon) {
        cartIcon.addEventListener('click', function() {
            cartSidebar.classList.add('open');
            loadCart();
        });
    }

    if (closeCart) {
        closeCart.addEventListener('click', function() {
            cartSidebar.classList.remove('open');
        });
    }

    // Load Cart
    function loadCart() {
        fetch('/cart')
            .then(response => response.json())
            .then(data => {
                updateCartUI(data);
            })
            .catch(error => console.error('Error loading cart:', error));
    }

    // Update Cart UI
    function updateCartUI(data) {
        const cartCount = document.getElementById('cart-count');
        const cartTotalPrice = document.getElementById('cart-total-price');
        const cartItems = document.getElementById('cart-items');

        if (cartCount) {
            cartCount.textContent = data.count + ' товаров на ' + data.total + '₽';
        }

        if (cartTotalPrice) {
            cartTotalPrice.textContent = data.total + '₽';
        }

        if (cartItems) {
            cartItems.innerHTML = '';

            for (const id in data.cart) {
                const item = data.cart[id];
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.dataset.id = id;
                cartItem.innerHTML = `
                    <div class="cart-item-image">
                        <img src="/storage/${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-volume">Объем: ${item.volume}</div>
                        <div class="cart-item-price">${item.price}₽</div>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn decrease">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn increase">+</button>
                        </div>
                    </div>
                    <button class="remove-item">&times;</button>
                `;

                cartItems.appendChild(cartItem);
            }

            // Decrease Quantity
            const decreaseButtons = document.querySelectorAll('.decrease');
            decreaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.dataset.id;
                    const quantitySpan = this.nextElementSibling;
                    const currentQuantity = parseInt(quantitySpan.textContent);

                    if (currentQuantity > 1) {
                        updateCartItem(cartItemId, currentQuantity - 1);
                    }
                });
            });

            // Increase Quantity
            const increaseButtons = document.querySelectorAll('.increase');
            increaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.dataset.id;
                    const quantitySpan = this.previousElementSibling;
                    const currentQuantity = parseInt(quantitySpan.textContent);

                    updateCartItem(cartItemId, currentQuantity + 1);
                });
            });

            // Remove Item
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    const cartItemId = cartItem.dataset.id;

                    removeCartItem(cartItemId);
                });
            });
        }
    }

    // Update Cart Item
    function updateCartItem(cartItemId, quantity) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('cart_item_id', cartItemId);
        formData.append('quantity', quantity);

        fetch('/cart/update', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                updateCartUI(data);
            })
            .catch(error => console.error('Error updating cart item:', error));
    }

    // Remove Cart Item
    function removeCartItem(cartItemId) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('cart_item_id', cartItemId);

        fetch('/cart/remove', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                updateCartUI(data);
            })
            .catch(error => console.error('Error removing cart item:', error));
    }

    // Add to cart from product page
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const drinkId = this.dataset.id;
            const volumeInput = document.querySelector('input[name="volume"]:checked');
            const volume = volumeInput ? volumeInput.value : null;

            if (!volume) {
                alert('Пожалуйста, выберите объем');
                return;
            }

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('drink_id', drinkId);
            formData.append('volume', volume);
            formData.append('quantity', 1);

            fetch('/cart/add', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = '/login';
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        updateCartUI(data);
                        document.getElementById('cart-sidebar').classList.add('open');
                    }
                })
                .catch(error => console.error('Error adding to cart:', error));
        });
    }

 // Volume selector on product page
const volumeInputs = document.querySelectorAll('input[name="volume"]');
const volumeSelector = document.querySelector('.volume-selector');
const volumeSelectorBg = document.querySelector('.volume-selector-bg');

if (volumeInputs.length > 0 && volumeSelectorBg && volumeSelector) {
    // Функция для обновления положения и размера фона
    function updateVolumeSelector() {
        const checkedInput = document.querySelector('input[name="volume"]:checked');
        if (checkedInput) {
            const volumeOption = checkedInput.closest('.volume-option');
            const optionWidth = volumeOption.offsetWidth;
            const optionLeft = volumeOption.offsetLeft;
            
            // Устанавливаем ширину и позицию фона
            volumeSelectorBg.style.width = optionWidth + 'px';
            volumeSelectorBg.style.transform = `translateX(${optionLeft}px)`;
        }
    }
    
    // Устанавливаем начальное положение фона
    window.addEventListener('load', updateVolumeSelector);
    
    // Обновляем положение при изменении выбора
    volumeInputs.forEach((input) => {
        input.addEventListener('change', function() {
            // Обновляем цену
            const price = this.dataset.price;
            const priceElement = document.querySelector('.price');
            if (priceElement) {
                priceElement.textContent = price;
            }
            
            // Обновляем положение фона
            updateVolumeSelector();
        });
    });
    
    // Обновляем положение при изменении размера окна
    window.addEventListener('resize', updateVolumeSelector);
}

    // Toggle favorite
    const favoriteBtn = document.querySelector('.favorite-btn');
    if (favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            const drinkId = this.dataset.id;
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            fetch('/drinks/' + drinkId + '/favorite', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = '/login';
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        if (data.status === 'added') {
                            favoriteBtn.classList.add('active');
                            favoriteBtn.querySelector('svg').setAttribute('fill', '#FFC300');
                        } else {
                            favoriteBtn.classList.remove('active');
                            favoriteBtn.querySelector('svg').setAttribute('fill', 'none');
                        }
                    }
                })
                .catch(error => console.error('Error toggling favorite:', error));
        });
    }
});