@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css')}}">
@endsection

@section('content')
<div class="item-detail__content">
    <div class="item-detail__image">
        {{-- ① 商品画像を表示（根拠：FN017-1-1） --}}
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" style="width: 30%;">
    </div>

    <div class="item-detail__description">
        {{-- ② 商品名とブランド名（根拠：FN017-1-2, 3） --}}
        <h1>{{ $item->name }}</h1>
        <p class="item-detail__brand">{{ $item->brand_name ?? 'ブランドなし' }}</p>

        {{-- ③ 価格（根拠：FN017-1-4） --}}
        <p class="item-detail__price">¥{{ number_format($item->price) }}（税込）</p>

        {{-- ④ 商品説明（根拠：FN017-1-7） --}}
        <h2>商品の説明</h2>
        <p>{{ $item->description }}</p>

        {{-- ⑤ 商品情報：カテゴリと状態（根拠：FN017-1-8） --}}
        <h2>商品の情報</h2>
        <div class="item-detail__info">
            <p><strong>カテゴリー:</strong>
                {{-- 多対多のカテゴリ表示は次のステップで詳しくやります --}}
                @foreach($item->categories as $category)
                <span class="category-tag">{{ $category->content }}</span>
                @endforeach
            </p>
            <p><strong>商品の状態:</strong> {{ $item->condition }}</p>
        </div>
    </div>
</div>
@endsection