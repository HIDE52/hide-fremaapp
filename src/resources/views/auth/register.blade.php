@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__heading">
        <h2>会員登録</h2>
    </div>

    <div class="register__form-inner">
        <form class="form" action="/register" method="post" novalidate>
            @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">ユーザー名</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="name" value="{{ old('name') }}" class="form__input">
                    @error('name')
                    <div class="form__error">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                </div>
                <div class="form__group-content">
                    <input type="email" name="email" value="{{ old('email') }}" class="form__input">
                    @error('email')
                    <div class="form__error">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">パスワード</span>
                </div>
                <div class="form__group-content">
                    <input type="password" name="password" class="form__input">
                    @error('password')
                    <div class="form__error">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">確認用パスワード</span>
                </div>
                <div class="form__group-content">
                    <input type="password" name="password_confirmation" class="form__input">
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">登録する</button>
            </div>
        </form>

        <div class="register__link">
            <a href="/login">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection


@error('')
<div class="form__error">
    <strong>{{ $message }}</strong>
</div>
@enderror