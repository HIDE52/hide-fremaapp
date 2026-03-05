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
                {{-- もし現在のURLが「/（トップページ）」の時だけ表示する --}}
                @if (Request::is('/'))
                <form action="/search" method="GET" class="header__search-form">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" class="header__search-input">
                </form>
                @endif
            </div>

            <nav class="header__right">
                <ul class="header__nav-list">
                    @auth
                    <li class="header__nav-item"><button class="header__nav-button">ログアウト</button></li>
                    <li class="header__nav-item"><a href="/mypage" class="header__nav-link">マイページ</a></li>
                    <li class="header__nav-item"><a href="/sell" class="header__nav-btn">出品</a></li>
                    @endauth

                    {{-- 修正案：すべてを条件分岐の「箱」に閉じ込める --}}
                    @guest
                    @if (!Request::is('login') && !Request::is('register'))
                    <li class="header__nav-item">
                        <a href="/login" class="header__nav-link">ログイン</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="/register" class="header__nav-link">会員登録</a>
                    </li>
                    {{-- 出品ボタンもこの中に入れる！ --}}
                    <li class="header__nav-item">
                        <a href="/sell" class="header__nav-btn">出品</a>
                    </li>
                    @endif
                    @endguest
                </ul>
            </nav>

        </div>
    </header>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>