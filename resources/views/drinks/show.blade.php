@extends('layouts.app')

@section('styles')
<style>
    body {
        background-image: url('{{ asset('storage/' . $drink->image) }}');
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
    
    @media screen and (max-width: 767px) {
        .drink-detail {
            width: 90%;
            max-width: 350px;
            padding: 20px;
        }
        
        .drink-name {
            font-size: 32px;
        }
        
        .drink-description {
            font-size: 24px;
            color: #414141;
        }
        
        .volume-selector {
            margin: 20px 0;
        }
    }
</style>
@endsection

@section('content')
<a href="{{ url()->previous() }}" class="close-btn">&times;</a>

<div class="drink-detail">
    <div class="favorite-btn {{ $isFavorite ? 'active' : '' }}" data-id="{{ $drink->id }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isFavorite ? '#FFC300' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </svg>
    </div>
    
    <div class="drink-info">
        <h1 class="drink-name">{{ $drink->name }}</h1>
        <p class="drink-description">{{ $drink->description }}</p>
        
        <div class="volume-selector">
            <div class="volume-selector-bg"></div>
            @foreach($drink->volumes as $index => $volume)
            <label class="volume-option">
                <input type="radio" name="volume" value="{{ $volume }}" data-price="{{ $drink->prices[$index] }}" {{ $index === 0 ? 'checked' : '' }}>
                <span>{{ $volume }}</span>
            </label>
            @endforeach
        </div>
        
        <button class="add-to-cart-btn" data-id="{{ $drink->id }}">
            + <span class="price">{{ $drink->prices[0] }}</span>₽
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Функция для обновления положения и размера фона
        function updateVolumeSelector() {
            const volumeSelector = document.querySelector('.volume-selector');
            const volumeSelectorBg = document.querySelector('.volume-selector-bg');
            const checkedInput = document.querySelector('input[name="volume"]:checked');
            
            if (checkedInput && volumeSelectorBg && volumeSelector) {
                const volumeOption = checkedInput.closest('.volume-option');
                const optionWidth = volumeOption.offsetWidth;
                const optionLeft = volumeOption.offsetLeft;
                
                // Устанавливаем ширину и позицию фона
                volumeSelectorBg.style.width = optionWidth + 'px';
                volumeSelectorBg.style.transform = `translateX(${optionLeft}px)`;
            }
        }
        
        // Устанавливаем начальное положение фона
        updateVolumeSelector();
        
        // Обновляем положение при изменении выбора
        const volumeInputs = document.querySelectorAll('input[name="volume"]');
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
    });
</script>
@endsection