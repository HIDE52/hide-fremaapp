@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile_edit.css') }}">
@endsection

@section('content')
<div class="main__container">
    <div class="profile-form">

        <div class="profile-form__header">
            <h1 class="profile-form__title">プロフィール設定</h1>
        </div>

        @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-form__avatar-group">
                <div class="profile-form__avatar-img">
                    <img src="{{ $user->img_url ? asset('storage/' . $user->img_url) : asset('img/default-user.png') }}" alt="ユーザーアイコン">
                </div>
                <label class="profile-form__avatar-label">
                    画像を選択する
                    <input type="file" name="img_url" class="profile-form__avatar-input">
                </label>
            </div>
            @error('img_url')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="profile-form__group">
                <label class="profile-form__label">ユーザー名</label>
                <input type="text" name="name" class="profile-form__input" value="{{ old('name', $user->name) }}">
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label">郵便番号</label>
                <input type="text" name="post_code" class="profile-form__input" value="{{ old('post_code', $user->postcode) }}">
                @error('post_code')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label">住所</label>
                <input type="text" name="address" class="profile-form__input" value="{{ old('address', $user->address) }}">
                @error('address')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label">建物名</label>
                <input type="text" name="building" class="profile-form__input" value="{{ old('building', $user->building) }}">
            </div>

            <div class="profile-form__btn-group">
                <button type="submit" class="profile-form__submit-btn">更新する</button>
            </div>

        </form>
    </div>
</div>
@endsection