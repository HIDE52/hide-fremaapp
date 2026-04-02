@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}">
@endsection

@section('content')
<div class="address-form">
    <div class="address-form__header">
        <h2 class="address-form__title">住所の変更</h2>
    </div>

    <div class="address-form__body-content">
        {{-- アクション先は商品の購入画面に戻れるよう item_id を保持 --}}
        <form class="form" action="{{ route('address.update', ['item_id' => $item_id]) }}" method="post" novalidate>
            @csrf
            {{-- 更新処理であることを示す --}}
            @method('PATCH')

            {{-- 1. 郵便番号 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">郵便番号</span>
                </div>
                <div class="form__group-content">
                    {{--
                        old('postcode') : 入力エラーで戻ってきた時の値
                        $user->postcode : 最初に入力されている現在の登録値
                    --}}
                    <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}" class="form__input">

                    {{-- 【ここが重要！】PurchaseRequest の postcode.required メッセージを表示 --}}
                    @error('postcode')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            {{-- 2. 住所 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form__input">

                    {{-- 【ここが重要！】PurchaseRequest の address.required メッセージを表示 --}}
                    @error('address')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            {{-- 3. 建物名 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form__input">
                    {{-- 建物名は任意（requiredがない）なら @error はなくてもOKですが、念のため置いておくと安心です --}}
                </div>
            </div>

            <div class="address-form__btn-group">
                <button class="address-form__btn-submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection