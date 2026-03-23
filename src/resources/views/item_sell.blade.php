@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_sell.css') }}">
@endsection

@section('content')
<div class="exhibit">
    <h1 class="exhibit__title">商品の出品</h1>

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 1. 商品画像セクション --}}
        <div class="exhibit__section">
            <h2 class="exhibit__section-title">商品画像</h2>
            <div class="exhibit__img-upload-container">
                <div class="exhibit__img-box">
                    <label class="exhibit__img-btn">
                        画像を選択する
                        <input type="file" name="img_url" class="exhibit__img-input" style="display:none;">
                    </label>
                </div>
                @error('img_url')
                <p class="exhibit__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 2. 商品の詳細セクション --}}
        <div class="exhibit__section">
            <h2 class="exhibit__section-title">商品の詳細</h2>

            <div class="exhibit__group">
                <label class="exhibit__label">カテゴリー</label>
                <div class="exhibit__category-list">
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
            </div>

            <div class="exhibit__group">
                <label class="exhibit__label">商品の状態</label>
                <div class="exhibit__select-wrapper">
                    <select name="condition" class="exhibit__select">
                        <option value="" disabled {{ old('condition') == '' ? 'selected' : '' }}>選択してください</option>
                        <option value="良好">良好</option>
                        <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                        <option value="状態が悪い">状態が悪い</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- 3. 商品名と説明セクション --}}
        <div class="exhibit__section">
            <h2 class="exhibit__section-title">商品名と説明</h2>

            <div class="exhibit__group">
                <label class="exhibit__label">商品名</label>
                <input type="text" name="name" class="exhibit__input" value="{{ old('name') }}">
            </div>

            <div class="exhibit__group">
                <label class="exhibit__label">ブランド名</label>
                <input type="text" name="brand_name" class="exhibit__input" value="{{ old('brand_name') }}">
            </div>

            <div class="exhibit__group">
                <label class="exhibit__label">商品の説明</label>
                <textarea name="description" class="exhibit__textarea">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- 4. 販売価格セクション（重複を解消したスッキリ構造） --}}
        <div class="exhibit__section">
            <h2 class="exhibit__section-title">販売価格</h2>
            <div class="exhibit__group-price">
                <label class="exhibit__label">販売価格</label>
                <div class="exhibit__price-container">
                    <span class="exhibit__price-unit">¥</span>
                    <input type="number" name="price" class="exhibit__price-input" value="{{ old('price') }}" placeholder="0">
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
@endsection