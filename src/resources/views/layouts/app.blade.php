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
    <header class="common-header">
        <div class="common-header__inner">

            <div class="common-header__logo">
                <a href="/" class="common-header__logo-link">
                    <img src="{{ asset('css/img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech" class="common-header__logo-img">
                </a>
            </div>

            @if (!Request::is('login') && !Request::is('register'))
            <div class="common-header__search">
                <form action="/" method="GET" class="common-header__search-form">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" class="common-header__search-input" value="{{ request('keyword') }}">
                </form>
            </div>
            @endif

            <nav class="common-header__nav">
                <ul class="common-header__nav-list">
                    @auth
                    <li class="common-header__nav-item">
                        <form class="common-header__logout-form" action="/logout" method="post">
                            @csrf
                            <button type="submit" class="common-header__nav-button">ログアウト</button>
                        </form>
                    </li>
                    <li class="common-header__nav-item"><a href="/mypage" class="common-header__nav-link">マイページ</a></li>
                    <li class="common-header__nav-item"><a href="/sell" class="common-header__nav-btn">出品</a></li>
                    @endauth

                    @guest
                    @if (!Request::is('login') && !Request::is('register'))
                    <li class="common-header__nav-item"><a href="/login" class="common-header__nav-link">ログイン</a></li>
                    <li class="common-header__nav-item"><a href="/mypage" class="common-header__nav-link">マイページ</a></li>
                    <li class="common-header__nav-item"><a href="/sell" class="common-header__nav-btn">出品</a></li>
                    @endif
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="main__container">
            @yield('content')
        </div>
    </main>
</body>

</html>