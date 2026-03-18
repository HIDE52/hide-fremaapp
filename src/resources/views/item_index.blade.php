@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_index.css') }}">
@endsection

@section('content')
<div class="index__content">
    <div class="index__inner">
        <div class="index__tabs">
            <a href="{{ route('item.index', ['keyword' => request('keyword')]) }}"
                class="index__tab {{ $tab !== 'mylist' ? 'index__tab--active' : '' }}">
                おすすめ
            </a>

            <a href="{{ route('item.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
                class="index__tab {{ $tab === 'mylist' ? 'index__tab--active' : '' }}">
                マイリスト
            </a>
        </div>

        <div class="item-list">
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
            <div class="index__empty">
                <p>該当する商品が見つかりませんでした。</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection



