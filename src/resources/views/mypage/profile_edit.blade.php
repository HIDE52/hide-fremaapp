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

        @if(session('message'))
            <div class="alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="profile-form__avatar-group">
                <div class="profile-form__avatar-img" id="avatar_box">
                    @if($user->img_url)
                        <img src="{{ asset('storage/' . $user->img_url) }}" alt="ユーザー画像" id="preview">
                    @else
                        <img src="" alt="プレビュー" id="preview" style="display: none;">
                        <div class="profile-form__avatar-default" id="default_circle"></div>
                    @endif
                </div>

                <label class="profile-form__avatar-label">
                    画像を選択する
                    <input type="file" name="img_url" class="profile-form__avatar-input" id="img_input" accept="image/*">
                </label>
            </div>
            @error('img_url')
                <span class="error-message">{{ $message }}</span>
            @enderror

            <div class="profile-form__group">
                <label class="profile-form__label">ユーザー名</label>
                <input type="text" name="name" class="profile-form__input" value="{{ old('name', $user->name) }}">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

<div class="profile-form__group">
                <label class="profile-form__label">郵便番号</label>
                <input type="text" name="postcode" class="profile-form__input"
                    value="{{ old('postcode', $user->postcode) }}"
                    autocomplete="off"> 
                @error('postcode')
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

<script>
    const imgInput = document.getElementById('img_input');
    const preview = document.getElementById('preview');
    const defaultCircle = document.getElementById('default_circle');

    imgInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (defaultCircle) {
                    defaultCircle.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection