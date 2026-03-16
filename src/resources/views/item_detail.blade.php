@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<main class="main">
    <div class="main__container">
        <div class="item-detail">
            <div class="item-detail__inner">
                {{-- 左側：画像 --}}
                <div class="item-detail__image-box">
                    @if (\Illuminate\Support\Str::startsWith($item->img_url, 'http'))
                    <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-detail__img">
                    @else
                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="item-detail__img">
                    @endif
                </div>

                {{-- 右側：情報 --}}
                <div class="item-detail__description-box">
                    {{-- 商品基本情報 --}}
                    <div class="item-detail__header">
                        <h1 class="item-detail__name">{{ $item->name }}</h1>
                        <p class="item-detail__brand">{{ $item->brand_name ?? 'ブランド名' }}</p>
                        <p class="item-detail__price">
                            <span class="item-detail__price-amount">¥{{ number_format($item->price) }}</span>
                            <span class="item-detail__price-tax">(税込)</span>
                        </p>
                    </div>

                    {{-- アクション（いいね・コメント） --}}
                    <div class="item-detail__action">
                        <div class="item-detail__action-item">
                            <span class="item-detail__icon--heart">❤</span>
                            <span class="item-detail__count">{{ $item->likes()->count() }}</span>
                        </div>
                        <div class="item-detail__action-item">
                            <span class="item-detail__icon--comment">💬</span>
                            <span class="item-detail__count">{{ $item->comments()->count() }}</span>
                        </div>
                    </div>

                    {{-- 購入ボタン --}}
                    <div class="item-detail__btn-group">
                        <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="item-detail__purchase-btn">購入手続きへ</a>
                    </div>

                    {{-- 商品説明 --}}
                    <div class="item-detail__section">
                        <h2 class="item-detail__section-title">商品の説明</h2>
                        <div class="item-detail__description-content">
                            <p class="item-detail__description-text">{{ $item->description }}</p>
                        </div>
                    </div>

                    {{-- 商品の情報 --}}
                    <div class="item-detail__section">
                        <h2 class="item-detail__section-title">商品の情報</h2>
                        <div class="item-detail__meta">
                            <div class="item-detail__meta-row">
                                <span class="item-detail__meta-label">カテゴリー</span>
                                <div class="item-detail__tags">
                                    @foreach($item->categories as $category)
                                    <span class="item-detail__tag">{{ $category->content }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="item-detail__meta-row">
                                <span class="item-detail__meta-label">商品の状態</span>
                                <span class="item-detail__meta-value">{{ $item->condition }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- ①・② コメントセクションの修正 --}}
                    <div class="item-detail__section">
                        <h2 class="item-detail__section-title">コメント({{ $item->comments()->count() }})</h2>

                        <div class="item-detail__comment-list">
                            {{-- 実際のコメントを表示 --}}
                            @foreach($item->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-item__user">
                                    <div class="comment-item__avatar"></div> {{-- ① アバター表示用 --}}
                                    <span class="comment-item__username">{{ $comment->user->name }}</span> {{-- ② 高さ調整対象 --}}
                                </div>
                                <div class="comment-item__content-box">
                                    {{ $comment->content }}
                                </div>
                            </div>
                            @endforeach

                            {{-- データがない場合の確認用テストパーツ --}}
                            @if($item->comments->isEmpty())
                            <div class="comment-item">
                                <div class="comment-item__user">
                                    <div class="comment-item__avatar"></div>
                                    <span class="comment-item__username">テストユーザー</span>
                                </div>
                                <div class="comment-item__content-box">
                                    まだコメントはありません。
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- コメント入力フォーム --}}
                        <div class="item-detail__comment-form">
                            <h3 class="comment-form__label">商品へのコメント</h3>
                            <form action="#" method="POST">
                                @csrf
                                <textarea name="comment" class="comment-form__textarea"></textarea>
                                <button type="submit" class="comment-form__submit">コメントを送信する</button>
                            </form>
                        </div>
                    </div>

                </div> {{-- /description-box --}}
            </div> {{-- /inner --}}
        </div>
    </div>
</main>
@endsection