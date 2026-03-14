@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_index.css') }}">
@endsection

@section('content')
<div class="index__content">
    <div class="index__inner">
        {{-- タブメニュー --}}
        <div class="index__tabs">
            {{-- おすすめタブ：keywordを維持して移動 --}}
            <a href="{{ route('item.index', ['keyword' => request('keyword')]) }}"
                class="index__tab {{ $tab !== 'mylist' ? 'index__tab--active' : '' }}">
                おすすめ
            </a>

            {{-- マイリストタブ：tab=mylist と keywordを維持して移動 --}}
            <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
                class="index__tab {{ $tab === 'mylist' ? 'index__tab--active' : '' }}">
                マイリスト
            </a>
        </div>

        {{-- 商品リスト --}}
        <div class="item-list">
            @forelse ($items as $item)
            <div class="item-card">
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item-card__link">
                    <div class="item-card__img-wrapper">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="item-card__img">

                        {{-- 売れ残り判定（Soldラベル） --}}
                        @if ($item->order)
                        <div class="item-card__sold-label">Sold</div>
                        @endif
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            </div>
            @empty
            {{-- 検索結果が0件の場合の表示 --}}
            <div class="index__empty">
                <p>該当する商品が見つかりませんでした。</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection