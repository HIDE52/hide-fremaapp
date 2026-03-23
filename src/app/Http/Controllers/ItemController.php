<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category; // 忘れずに追加！

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        $query = Item::with('order')->keywordSearch($keyword);

        if ($tab === 'mylist') {
            $items = $user ? $user->likeItems()->with('order')->keywordSearch($keyword)->get() : collect();
        } else {
            if ($user) {
                $query->where('user_id', '!=', $user->id);
            }
            $items = $query->get();
        }

        return view('item_index', compact('items', 'tab'));
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments', 'likes'])->findOrFail($item_id);
        return view('item_detail', compact('item'));
    }

    public function sell()
    {
        $categories = Category::all(); // メニュー表（カテゴリー一覧）を準備

        // compactでViewにカテゴリーデータを届ける
        return view('item_sell', compact('categories'));
    }

    // 出品画面を表示する
    public function create()
    {
        $categories = Category::all();
        return view('item_sell', compact('categories'));
    }

    // 出品内容を保存する
    public function store(Request $request)
    {
        // 1. 画像の保存
        // アップロードされたファイルを 'public/items' フォルダに保存し、そのパスを取得します
        $img_path = $request->file('img_url')->store('public/items');
        // データベースには 'storage/items/xxx.jpg' の形式で保存するためにパスを変換します
        $img_url = str_replace('public/', 'storage/', $img_path);

        // 2. 商品データの作成
        // Itemモデルを使って、新しいデータの箱を作ります
        $item = Item::create([
            'user_id'     => Auth::id(),           // ログイン中のユーザーID
            'condition'   => $request->condition,  // 商品の状態
            'name'        => $request->name,       // 商品名
            'brand_name'  => $request->brand_name, // ブランド名
            'description' => $request->description, // 商品の説明
            'price'       => $request->price,      // 価格
            'img_url'     => $img_url,             // 画像のパス
        ]);

        // 3. カテゴリーの紐付け（中間テーブルへの保存）
        // チェックボックスで選ばれた複数のカテゴリーIDを中間テーブルに保存します
        $item->categories()->attach($request->categories);

        // 4. 完了後の移動
        // 出品が終わったら、トップページ（商品一覧）に戻ります
        return redirect('/')->with('message', '商品を出品しました');
    }
}
