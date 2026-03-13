@extends('layouts.app')

@section('css')
{{-- asset関数を使って、public/css/index.css を読み込みます --}}
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="index__content">
    <div class="index__inner">

        {{-- タブ部分：現時点では「おすすめ」をアクティブに固定していますが、
             今後のタスク（マイリスト実装）でここを動的に切り替えます --}}
        <div class="index__tabs">
            <a href="/" class="index__tab index__tab--active">おすすめ</a>
            <a href="/?tab=mylist" class="index__tab">マイリスト</a>
        </div>

        {{-- 商品一覧：Controllerから渡された $items をループで回します --}}
        <div class="item-list">
            @foreach($items as $item)
            <div class="item-card">
                {{-- 根拠：基本設計書のパス /item/{item_id} に合わせてリンクを作成 --}}
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item-card__link">

                    <div class="item-card__img-wrapper">
                        {{-- 根拠：FN014-2 商品画像の表示 --}}
                        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-card__img">

                        {{-- 売り切れ時のラベル（判定ロジックの修正）
                             根拠：FN014-3 購入済み商品は "Sold" と表示される
                             視点：Itemsテーブルに列を増やさず、Orderテーブルとの接続(リレーション)で判定します --}}
                        @if($item->order)
                        <span class="item-card__sold-label">Sold</span>
                        @endif
                    </div>

                    <div class="item-card__content">
                        {{-- 根拠：FN014-2 商品名の表示 --}}
                        <p class="item-card__name">{{ $item->name }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection