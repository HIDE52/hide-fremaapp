@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_index.css') }}">
@endsection

@section('content')
<div class="item-index">
    {{-- 追加ポイント：出品完了などのフラッシュメッセージを表示するエリア --}}
    @if (session('message'))
    <div class="item-index__flash">
        {{ session('message') }}
    </div>
    @endif

    <div class="item-index__tabs">
        <a href="{{ route('item.index', ['keyword' => request('keyword')]) }}"
            class="item-index__tab {{ $tab !== 'mylist' ? 'item-index__tab--active' : '' }}">
            おすすめ
        </a>

        <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
            class="item-index__tab {{ $tab === 'mylist' ? 'item-index__tab--active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="item-index__list">
        @forelse ($items as $item)
        <div class="item-card">
            <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item-card__link">
                <div class="item-card__img-wrapper">
                    @if (\Illuminate\Support\Str::startsWith($item->img_url, 'http'))
                    <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-card__img">
                    @else
                    <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}" class="item-card__img">
                    @endif

                    @if ($item->order)
                    <div class="item-card__sold-label">Sold</div>
                    @endif
                </div>
                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        </div>
        @empty
        <div class="item-index__empty">
            <p>該当する商品が見つかりませんでした。</p>
        </div>
        @endforelse
    </div>
</div>
@endsection