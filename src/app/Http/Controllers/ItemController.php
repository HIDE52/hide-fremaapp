<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * 商品一覧ページを表示
     * * 案①（教科書通り）: indexメソッドで全データの取得と条件分岐を行います。
     * 案②（今回の実装）: リレーション(with)を使って、効率よく「Sold」判定用のデータを取得します。
     */
    public function index()
    {
        // 1. ログインしている自分の「背番号（ID）」を確認する
        // 根拠：誰がログインしているかで、除外する商品が変わるため
        $userId = Auth::id();

        // 2. データの取得条件を作成
        // 視点：with('order') を入れることで、Viewでの「Sold」判定が高速になります
        $query = Item::with('order');

        if ($userId) {
            /**
             * ログイン中の場合：自分以外の出品物を取得
             * 根拠：機能要件 FN014-4「自分が出品した商品は表示されない」
             * 分解：where('カラム名', '記号', '比較する値')
             */
            $items = $query->where('user_id', '!=', $userId)->get();
        } else {
            /**
             * ログインしていない場合：全商品を取得
             * 根拠：機能要件 FN014-5「未認証ユーザーにも表示」
             */
            $items = $query->get();
        }

        /**
         * 3. 取得した商品リストを 'index' 画面に渡す
         * 視点：compactを使うことで、View側で $items という変数名でデータが扱えるようになります
         */
        return view('index', compact('items'));
    }

    /**
     * 商品詳細ページを表示
     * * 根拠：機能要件 FN017「商品詳細情報取得」
     */
    public function show($item_id)
    {
        // DBから指定されたIDの商品を1件取得（なければ404エラーを出す）
        // 視点：詳細画面でもカテゴリやコメントが必要になるため、後ほどリレーションを追加します
        $item = Item::findOrFail($item_id);

        return view('item_detail', compact('item'));
    }

    /**
     * 商品出品ページを表示
     * * 根拠：機能要件 FN028「出品商品情報登録機能」の入り口
     */
    public function sell()
    {
        return view('item_sell');
    }
}
