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
        <form class="form" action="{{ route('address.update', ['item_id' => $item_id]) }}" method="post" novalidate>
            @csrf

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">郵便番号</span>
                </div>

                <div class="form__group-content">
                    <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}" class="form__input">

                    @error('postcode')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form__input">

                    @error('address')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form__input">
                </div>
            </div>

            <div class="address-form__btn-group">
                <button class="address-form__btn-submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection