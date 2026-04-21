@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__image-box">
        <div class="item-detail__image-inner">
            <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}"
                alt="{{ $item->name }}"
                class="item-detail__image">
        </div>
    </div>

    <div class="item-detail__description-box">
        <div class="item-detail__header">
            <h1 class="item-detail__name">{{ $item->name }}</h1>
            @if(!is_null($item->brand_name))
                <p class="item-detail__brand">{{ $item->brand_name }}</p>
            @endif
        </div>

        <div class="item-detail__price">
            <span class="item-detail__price-amount">¥{{ number_format($item->price) }}</span>
            <span class="item-detail__price-tax">(税込)</span>
        </div>

        <div class="item-detail__action">
            <div class="item-detail__action-item">
                <form action="{{ route('like.store', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="item-detail__like-btn">
                        <img src="{{ $item->isLikedByAuthUser() ? asset('css/img/ハートロゴ_ピンク.png') : asset('css/img/ハートロゴ_デフォルト.png') }}" 
                             alt="いいね" 
                             class="item-detail__icon--heart">
                    </button>
                </form>
                <span class="item-detail__count">{{ $item->likes->count() }}</span>
            </div>

            <div class="item-detail__action-item">
                <a href="#comment-list" class="item-detail__comment-link">
                    <img src="{{ asset('css/img/ふきだしロゴ.png') }}" alt="コメント" class="item-detail__icon--comment">
                </a>
                <span class="item-detail__count">{{ $item->comments->count() }}</span>
            </div>
        </div>

        <div class="item-detail__btn-group">
            @if($item->order)
            <button class="item-detail__purchase-btn is-sold" disabled>売り切れました</button>
            @else
            <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="item-detail__purchase-btn">
                購入手続きへ
            </a>
            @endif
        </div>

        <div class="item-detail__section">
            <h2 class="item-detail__section-title">商品の説明</h2>
            <div class="item-detail__description-content">
                <p class="item-detail__description-text">{{ $item->description }}</p>
            </div>
        </div>

        <div class="item-detail__section">
            <h2 class="item-detail__section-title">商品の情報</h2>
            <div class="item-detail__info-group">
                <p class="item-detail__info-label">カテゴリー</p>
                <div class="item-detail__category-list">
                    @foreach($item->categories as $category)
                    <span class="item-detail__category-tag">{{ $category->content }}</span>
                    @endforeach
                </div>
            </div>
            <div class="item-detail__info-group">
                <p class="item-detail__info-label">商品の状態</p>
                <p class="item-detail__info-value">{{ $item->condition }}</p>
            </div>
        </div>

        <div id="comment-list" class="item-detail__comment-section">
            <h2 class="item-detail__comment-count">コメント({{ $item->comments->count() }})</h2>
            @foreach($item->comments as $comment)
            <div class="item-detail__comment-item">
                <div class="item-detail__comment-user">
                    <div class="item-detail__comment-user-icon">
                        @if($comment->user->img_url)
                        <img src="{{ asset('storage/' .$comment->user->img_url) }}" alt="{{ $comment->user->name }}" class="item-detail__comment-avatar">
                        @endif
                    </div>
                    <span class="item-detail__comment-user-name">{{ $comment->user->name }}</span>
                </div>
                <div class="item-detail__comment-text-box">
                    <p class="item-detail__comment-text">{{ $comment->comment }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <form action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="POST" class="item-detail__comment-form">
            @csrf
            <h3 class="item-detail__comment-form-title">商品へのコメント</h3>
            @error('comment')
            <p class="item-detail__comment-error">{{ $message }}</p>
            @enderror
            <textarea name="comment" class="item-detail__comment-textarea @error('comment') is-error @enderror" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
            <button type="submit" class="item-detail__comment-submit">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection