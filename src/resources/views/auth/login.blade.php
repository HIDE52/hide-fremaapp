@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
{{-- クラス名も register に合わせるか、login に書き換えて構造を統一します --}}
<div class="login__content">
    <div class="login__heading">
        <h2>ログイン</h2>
    </div>

    <div class="login__form-inner">
        <form class="form" action="/login" method="post" novalidate>
            @csrf
            {{-- メールアドレス --}}
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                </div>
                <div class="form__group-content">
                    <input type="email" name="email" value="{{ old('email') }}" class="form__input">
                    @error('email')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            {{-- パスワード --}}
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">パスワード</span>
                </div>
                <div class="form__group-content">
                    <input type="password" name="password" class="form__input">
                    @error('password')
                    <div class="form__error"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>

            {{-- ボタン：ここがポイント --}}
            <div class="form__button">
                <button class="form__button-submit" type="submit">ログインする</button>
            </div>
        </form>

        {{-- 会員登録画面へのリンク --}}
        <div class="login__link">
            <a href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection