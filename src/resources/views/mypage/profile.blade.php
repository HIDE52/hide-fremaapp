@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/item_index.css') }}">
@endsection

@section('content')
<div class="main__container">
    <div class="profile-header">
        <div class="profile-header__user-info">
            <div class="profile-header__avatar">
                @if($user->img_url)
                <img src="{{ \Illuminate\Support\Str::startsWith($user->img_url, ['http://', 'https://']) ? $user->img_url : asset('storage/' . $user->img_url) }}" alt="ユーザー画像" class="profile-header__avatar-img">
                @else
                <div class="profile-header__avatar-default"></div>
                @endif
            </div>
            <h1 class="profile-header__user-name">{{ $user->name }}</h1>
        </div>
        <div class="profile-header__action">
            <a href="{{ route('profile.edit') }}" class="profile-header__edit-btn">プロフィールを編集</a>
        </div>
    </div>

    <div class="profile-tabs">
        <a href="{{ route('mypage', ['tab' => 'sell']) }}"
            class="profile-tabs__tab {{ $tab === 'sell' ? 'profile-tabs__tab--active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypage', ['tab' => 'buy']) }}"
            class="profile-tabs__tab {{ $tab === 'buy' ? 'profile-tabs__tab--active' : '' }}">
            購入した商品
        </a>
    </div>

    <div class="item-index__list">
        @forelse ($items as $item)
        <div class="item-card">
            <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item-card__link">
                <div class="item-card__img-wrapper">
                    <img src="{{ \Illuminate\Support\Str::startsWith($item->img_url, ['http://', 'https://']) ? $item->img_url : asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="item-card__img">
                    @if($item->order)
                    <span class="item-card__sold">Sold</span>
                    @endif
                </div>
                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        </div>
        @empty
        <div class="item-index__empty">
            <p>まだ商品はありません。</p>
        </div>
        @endforelse
    </div>
</div>
@endsection