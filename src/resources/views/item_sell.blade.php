@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_sell.css') }}">
@endsection

@section('content')
<div class="main__container">
    <div class="exhibit">

        <h1 class="exhibit__title">商品の出品</h1>

        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="exhibit__section">
                <h2 class="exhibit__section-title">商品画像</h2>
                <div class="exhibit__img-box">
                    <label class="exhibit__img-btn">
                        画像を選択する
                        <input type="file" name="img_url" id="img_input" style="display:none;">
                    </label>
                    <p id="file_name_display" class="exhibit__file-name"></p>
                </div>
                @error('img_url')
                <p class="exhibit__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="exhibit__section">
                <h2 class="exhibit__section-title">商品の詳細</h2>

                <div class="exhibit__group">
                    <label class="exhibit__label">カテゴリー</label>
                    <div class="exhibit__category-grid">
                        @foreach($categories as $category)
                        <div class="exhibit__category-item">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                id="category_{{ $category->id }}"
                                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                            <label for="category_{{ $category->id }}" class="exhibit__category-label">
                                {{ $category->content }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('categories')
                    <p class="exhibit__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="exhibit__group">
                    <label class="exhibit__label">商品の状態</label>
                    <select name="condition" class="exhibit__select" required>
                        <option value="" disabled {{ old('condition') == '' ? 'selected' : '' }}>選択してください</option>
                        <option value="1" {{ old('condition') == '1' ? 'selected' : '' }}>良好</option>
                        <option value="2" {{ old('condition') == '2' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                        <option value="3" {{ old('condition') == '3' ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="4" {{ old('condition') == '4' ? 'selected' : '' }}>状態が悪い</option>
                    </select>
                    @error('condition')
                    <p class="exhibit__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="exhibit__section">
                <h2 class="exhibit__section-title">商品名と説明</h2>
                <div class="exhibit__group">
                    <label class="exhibit__label">商品名</label>
                    <input type="text" name="name" class="exhibit__input" value="{{ old('name') }}">
                    @error('name')
                    <p class="exhibit__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="exhibit__group">
                    <label class="exhibit__label">ブランド名</label>
                    <input type="text" name="brand_name" class="exhibit__input" value="{{ old('brand_name') }}">
                </div>
                <div class="exhibit__group">
                    <label class="exhibit__label">商品の説明</label>
                    <textarea name="description" class="exhibit__textarea">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="exhibit__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="exhibit__section">
                <h2 class="exhibit__section-title">販売価格</h2>
                <div class="exhibit__group">
                    <div class="exhibit__price-container">
                        <div class="exhibit__price-input-flex">
                            <span class="exhibit__price-symbol">¥</span>
                            <input type="number" name="price" class="exhibit__price-input"
                                value="{{ old('price') }}" placeholder="0" min="0">
                        </div>
                    </div>
                    @error('price')
                    <p class="exhibit__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="exhibit__btn-group">
                <button type="submit" class="exhibit__submit">出品する</button>
            </div>
        </form>
    </div>
</div>

<script>
    const imgInput = document.getElementById('img_input');
    const fileNameDisplay = document.getElementById('file_name_display');

    imgInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            fileNameDisplay.textContent = '選択中: ' + files[0].name;
            fileNameDisplay.style.color = '#ff4b4b';
        }
    });
</script>
@endsection