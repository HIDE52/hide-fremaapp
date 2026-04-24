@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_purchase.css') }}?{{ date('YmdHis') }}">
@endsection

@section('content')
<div class="purchase__container">
    <form action="/purchase/{{ $item->id }}" method="POST" class="purchase__form" id="payment-form" novalidate>
        @csrf

        @php
        $postcode = session('shipping_address.postcode', $user->postcode);
        $address = session('shipping_address.address', $user->address);
        $building = session('shipping_address.building', $user->building);
        @endphp
        <input type="hidden" name="postcode" value="{{ $postcode }}">
        <input type="hidden" name="address" value="{{ $address }}">
        <input type="hidden" name="building" value="{{ $building }}">

        <div class="purchase__main">
            <section class="item-summary is-bordered">
                <div class="item-summary__image">
                    <img src="{{ \Illuminate\Support\Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-summary__content">
                    <h2 class="item-summary__name">{{ $item->name }}</h2>
                    <p class="item-summary__price">¥ {{ number_format($item->price) }}</p>
                </div>
            </section>

            <div class="purchase__group is-bordered">
                <label class="purchase__label">支払い方法</label>
                <div class="purchase__select-wrapper">
                    <select name="payment_method" id="payment_method" class="purchase__select">
                        <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>選択してください</option>
                        <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                    @error('payment_method')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            <div class="purchase__group is-bordered">
                <div class="purchase__address-header">
                    <label class="purchase__label">配送先</label>
                    <a href="/purchase/address/{{ $item->id }}" class="purchase__link">変更する</a>
                </div>

                <div class="purchase__address-wrapper">
                    @if(empty($address))
                    <p class="form__error">※配送先が設定されていません。右上の「変更する」から登録してください。</p>
                    @else
                    <p class="purchase__address">
                        〒 {{ $postcode }}<br>
                        {{ $address }} {{ $building }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <aside class="purchase__sidebar">
            <div class="sidebar__summary-container">
                <div class="summary-item is-bordered-bottom">
                    <span class="summary-item__label">商品代金</span>
                    <span class="summary-item__value">¥ {{ number_format($item->price) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-item__label">支払い方法</span>
                    <span id="display-payment" class="summary-item__value">選択してください</span>
                </div>
            </div>
            <button type="submit" id="purchase-button" class="purchase__btn">購入する</button>
        </aside>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const paymentSelect = document.getElementById('payment_method');
    const displayPayment = document.getElementById('display-payment');
    const btn = document.getElementById('purchase-button');
    const form = document.getElementById('payment-form');

    // 右側の「支払い方法」表示を更新するだけの関数
    function updateDisplay() {
        const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
        displayPayment.textContent = (paymentSelect.value) ? selectedOption.text : '選択してください';
    }

    paymentSelect.addEventListener('change', updateDisplay);
    window.addEventListener('DOMContentLoaded', updateDisplay);

    // 送信時の処理
    form.addEventListener('submit', (event) => {
        // すでにボタンが押されていたら何もしない（二重送信防止）
        if (btn.disabled) {
            event.preventDefault();
            return;
        }

        // ボタンを無効化して「処理中」にする
        btn.disabled = true;
        btn.textContent = '処理中...';
        
        // そのままフォームを送信（LaravelのControllerへ飛ばす）
    });
</script>
@endsection