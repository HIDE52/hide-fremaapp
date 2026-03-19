@extends('layouts.app')

@section('content')
<style>
    /* 全体のコンテナ：幅を制限し、中央に寄せる */
    .purchase__container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: sans-serif;
        /* シンプルなフォントに */
    }

    /* タイトル */
    .purchase__title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    /* コンテンツエリア：左右2カラム */
    .purchase__content {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    /* 左側：メインカラム（幅の60%） */
    .purchase__main-column {
        flex: 0 1 60%;
    }

    /* 商品カード：画像とテキストを横並びに */
    .purchase__item-card {
        display: flex;
        gap: 20px;
        align-items: center;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* 少し影をつけてカードらしく */
    }

    /* 【最重要】画像の枠：サイズを150pxで固定 */
    .purchase__item-image {
        flex: 0 0 150px;
        width: 150px;
        height: 150px;
        background: #f0f0f0;
        overflow: hidden;
        /* 枠からはみ出した画像を隠す */
        border-radius: 4px;
    }

    /* 【最重要】画像自体：枠の中に綺麗に収める */
    .purchase__item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* 画像が歪まないように収める */
    }

    /* 商品詳細テキスト */
    .purchase__item-detail {
        flex: 1;
    }

    .purchase__item-name {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .purchase__item-price {
        font-size: 20px;
        color: #ff5a5f;
        /* 価格を赤く */
        font-weight: bold;
    }

    /* 各セクションの余白 */
    .purchase__section {
        margin-bottom: 25px;
    }

    .purchase__section-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #555;
    }

    /* 入力・リンク */
    .purchase__select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
    }

    .purchase__address-info {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        line-height: 1.6;
    }

    .purchase__link {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
        margin-left: 10px;
    }

    /* 右側：サイドカラム（幅を300pxで固定） */
    .purchase__side-column {
        flex: 0 0 300px;
        width: 300px;
    }

    /* 確認用カード */
    .purchase__summary-card {
        background: #fff;
        border: 2px solid #ff5a5f;
        /* 目立つ枠線 */
        padding: 20px;
        border-radius: 8px;
    }

    .purchase__summary-table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .purchase__summary-table th,
    .purchase__summary-table td {
        padding: 10px 0;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .purchase__submit-btn {
        width: 100%;
        padding: 15px;
        background-color: #ff5a5f;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .purchase__submit-btn:hover {
        background-color: #e04e52;
        /* ホバーで少し暗く */
    }
</style>
<main class="main">
    <div class="purchase__container">
        <h1 class="purchase__title">購入手続き</h1>

        <div class="purchase__content">
            <div class="purchase__main-column">
                <section class="purchase__section">
                    <div class="purchase__item-card">
                        <div class="purchase__item-image">
                            <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="purchase__item-detail">
                            <h2 class="purchase__item-name">{{ $item->name }}</h2>
                            <p class="purchase__item-price">¥{{ number_format($item->price) }}</p>
                        </div>
                    </div>
                </section>

                <section class="purchase__section">
                    <h2 class="purchase__section-title">支払い方法</h2>
                    <select name="payment_method" class="purchase__select">
                        <option value="">選択してください</option>
                        <option value="konbini">コンビニ払い</option>
                        <option value="card">カード払い</option>
                    </select>
                </section>

                <section class="purchase__section">
                    <div class="purchase__section-header">
                        <h2 class="purchase__section-title">配送先</h2>
                        <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="purchase__link">変更する</a>
                    </div>
                    <div class="purchase__address-info">
                        <p>〒 {{ $postcode }}</p>
                        <p>{{ $address }}</p>
                        <p>{{ $building }}</p>
                    </div>
                </section>
            </div>

            <aside class="purchase__side-column">
                <div class="purchase__summary-card">
                    <table class="purchase__summary-table">
                        <tr>
                            <th>商品代金</th>
                            <td>¥{{ number_format($item->price) }}</td>
                        </tr>
                        <tr>
                            <th>支払い方法</th>
                            <td id="selected-payment">未選択</td>
                        </tr>
                    </table>
                    <button type="submit" class="purchase__submit-btn">購入する</button>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection