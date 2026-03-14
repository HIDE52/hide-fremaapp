<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * 商品一覧（おすすめ/マイリスト切り替え ＋ 検索機能）
     * * 案②：今回の実装
     * 検索ワード（keyword）を受け取り、一覧表示に反映させます。
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. URLからパラメータ（tab と keyword）を取得
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        // 2. 商品検索のクエリ（命令の準備）を開始
        // keywordSearchスコープ（工程②で作成）を呼び出して、キーワードがあれば絞り込む
        $query = Item::with('order')->keywordSearch($keyword);

        if ($tab === 'mylist') {
            // --- マイリスト表示の場合 ---
            // ログイン中なら「自分がいいねした商品」に絞り込み
            // 検索キーワードがあれば、その「いいねした商品」の中からさらに絞り込まれます
            $items = $user ? $user->likeItems()->with('order')->keywordSearch($keyword)->get() : collect();
        } else {
            // --- おすすめ表示（デフォルト）の場合 ---
            // ログイン中なら「自分以外の出品物」を表示
            if ($user) {
                $query->where('user_id', '!=', $user->id);
            }
            $items = $query->get();
        }

        // 3. 取得した商品データと現在の状態をViewに渡す
        return view('item_index', compact('items', 'tab'));
    }

    // 商品詳細表示
    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments'])->findOrFail($item_id);
        return view('item_detail', compact('item'));
    }

    // 商品出品画面の表示
    public function sell()
    {
        return view('item_sell');
    }
}
