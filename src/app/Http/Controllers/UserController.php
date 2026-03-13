<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // ★ 1. ログインIDを取得する
        // ここでデータを止めて表示させる
        dd('コントローラーのupdateメソッドまで届きました！', $request->all());

        $userId = Auth::id();

        // ログインが切れていないかのチェック（念のため残します）
        if (!$userId) {
            return redirect()->route('login')->with('error', 'セッションが切れました。ログインし直してください。');
        }

        // ★ 2. データベースから対象のユーザーを探す
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return "エラー：ユーザー情報が見つかりません。";
        }

        /* |--------------------------------------------------------------------------
        | 【検証用 dd】
        | 保存処理が正常に動くことが確認できたら、以下の dd は不要になります。
        | 現在は、処理を止めないようにコメントアウトしています。
        |--------------------------------------------------------------------------
        */
        /*
        dd([
            'status' => '4. 保存直前まで到達！',
            'login_id' => $userId,
            'user_from_db' => $user->toArray(),
            'request_data' => $request->all()
        ]);
        */

        // ★ 3. 実際の保存処理
        // フォームから送られてきた値を、データベースの各項目に代入します
        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        // 画像がアップロードされている場合のみ実行
        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('public/profiles');
            $user->img_url = basename($path);
        }

        // データベースに書き込みを実行
        $user->save();

        // ★ 4. 完了後の画面遷移
        // 指定したルート（編集画面など）へ戻り、完了メッセージを添えます
        return redirect()->route('profile.edit')->with('message', 'プロフィールを更新しました');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }
}
