@extends('layouts.app')

@section('css')
{{-- 設計書のルールに基づき、詳細画面専用のCSSを指定 --}}
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<div class="item-detail__content">
    {{-- 左側：商品画像エリア --}}
    <div class="item-detail__image">
        {{-- ① 商品画像を表示（根拠：FN017-1-1） --}}
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" style="width: 50%;">
    </div>

    {{-- 右側：商品情報エリア --}}
    <div class="item-detail__description">
        {{-- ② 商品名とブランド名（根拠：FN017-1-2, 3） --}}
        <h1>{{ $item->name }}</h1>
        <p class="item-detail__brand">{{ $item->brand_name ?? 'ブランドなし' }}</p>

        {{-- ③ 価格（根拠：FN017-1-4） --}}
        <p class="item-detail__price">¥{{ number_format($item->price) }}（税込）</p>

        {{-- ★追加：いいねボタン・カウントエリア（Task B：いいね機能の土台） --}}
        <div class="item-detail__like-section">
            <div class="like-button">
                {{-- クライアント確認後のアクション実装まで、アイコンのみ配置 --}}
                <span class="star-icon">☆</span>
                {{-- likesテーブルから件数を取得 --}}
                <p class="like-count">{{ $item->likes()->count() }}</p>
            </div>
            {{-- コメント数（今後実装予定） --}}
            <div class="comment-count-section">
                <span class="comment-icon">💬</span>
                <p class="comment-count">{{ $item->comments()->count() }}</p>
            </div>
        </div>

        {{-- 購入手続きボタン（UserController@purchaseへ） --}}
        <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="btn-purchase">購入手続きへ</a>

        {{-- ④ 商品説明（根拠：FN017-1-7） --}}
        <div class="item-detail__text">
            <h2>商品の説明</h2>
            <p>{{ $item->description }}</p>
        </div>

        {{-- ⑤ 商品情報：カテゴリと状態（根拠：FN017-1-8） --}}
        <div class="item-detail__info">
            <h2>商品の情報</h2>
            <div class="info-group">
                <p><strong>カテゴリー:</strong>
                    {{-- 修正後のItemモデルのリレーション(categories)を使用 --}}
                    @foreach($item->categories as $category)
                    <span class="category-tag">{{ $category->content }}</span>
                    @endforeach
                </p>
                <p><strong>商品の状態:</strong> {{ $item->condition }}</p>
            </div>
        </div>
    </div>
</div>
@endsection