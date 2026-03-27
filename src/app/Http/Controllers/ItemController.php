<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

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

    public function create()
    {
        $categories = Category::all();
        return view('item_sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request) // Request から ExhibitionRequest に変更
    {
        // 1. バリデーションは ExhibitionRequest が自動でやってくれるので、ここは不要になります

        // // 2. 画像の保存（安全な書き方）
        // $img_url = null; // 初期値
        // if ($request->hasFile('img_url')) {
        //     $img_path = $request->file('img_url')->store('items', 'public');
        //     $img_url = 'storage/' . $img_path;
        // }
        $img_url = 'storage/items/test.png'; // テスト用のダミーパス
        // 3. データベースへの登録
        $item = Item::create([
            'user_id'     => Auth::id(),
            'condition'   => $request->condition,
            'name'        => $request->name,
            'brand_name'  => $request->brand_name,
            'description' => $request->description,
            'price'       => $request->price,
            'img_url'     => $img_url, // 画像がなければ null が入る（DBが許可していれば）
        ]);

        $item->categories()->attach($request->categories);

        return redirect()->route('item.index')->with('message', '商品を出品しました');
    }
}
