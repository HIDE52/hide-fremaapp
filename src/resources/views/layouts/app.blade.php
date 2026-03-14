<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__container">

            <div class="header__left">
                <a href="/" class="header__logo-link">
                    <img src="{{ asset('css/img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech" class="header__logo-img">
                </a>
            </div>

            <div class="header__center">
                {{-- 【修正箇所】Request::is('/') だけでなく、マイリストタブ表示中なども検索窓が出るように調整 --}}
                {{-- また、actionを基本設計のルート（/）に合わせ、入力保持(value)を追加しました --}}
                @if (!Request::is('login') && !Request::is('register'))
                <form action="/" method="GET" class="header__search-form">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" class="header__search-input" value="{{ request('keyword') }}">
                </form>
                @endif
            </div>

            <nav class="header__right">
                <ul class="header__nav-list">
                    {{-- 【認証後】ログインしている人のための表示 --}}
                    @auth
                    <li class="header__nav-item">
                        <form class="header__logout-form" action="/logout" method="post">
                            @csrf
                            <button type="submit" class="header__nav-button">ログアウト</button>
                        </form>
                    </li>
                    <li class="header__nav-item"><a href="/mypage" class="header__nav-link">マイページ</a></li>
                    <li class="header__nav-item"><a href="/sell" class="header__nav-btn">出品</a></li>
                    @endauth

                    {{-- 【未認証】ログインしていない人（ゲスト）のための表示 --}}
                    @guest
                    @if (!Request::is('login') && !Request::is('register'))
                    <li class="header__nav-item">
                        <a href="/login" class="header__nav-link">ログイン</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="/mypage" class="header__nav-link">マイページ</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="/sell" class="header__nav-btn">出品</a>
                    </li>
                    @endif
                    @endguest
                </ul>
            </nav>

        </div>
    </header>

    <main>
        <div class="main__container">
            @yield('content')
        </div>
    </main>
</body>

</html>