@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<h1>商品一覧ページ</h1>

<div style="display: flex; flex-wrap: wrap;">
    @foreach($items as $item)
    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px; width: 200px;">
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" style="width: 100%;">

        <h3>{{ $item->name }}</h3>
        <p>価格：{{ number_format($item->price) }}円</p>

        {{-- ★ここを追加！ブランド名を表示する --}}
        {{-- $item->brand_name が空(null)なら 'なし' と表示されます --}}
        <p>ブランド：{{ $item->brand_name ?? 'なし' }}</p>

        <p>状態：{{ $item->condition }}</p>
    </div>
    @endforeach
</div>
@endsection