<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // 商品の設計図（モデル）を呼び出す

class ItemController extends Controller
{
    public function index()
    {
        // 1. データベースから商品テーブルのデータをすべて取ってくる
        // たとえ話：冷蔵庫から商品（食材）を全部取り出します。
        $items = Item::all();

        // 2. 取ってきたデータを「index」という名前の画面（Blade）に渡す
        // たとえ話：取り出した食材を、盛り付け担当（Blade）にパスします。
        return view('index', compact('items'));
    }
}
