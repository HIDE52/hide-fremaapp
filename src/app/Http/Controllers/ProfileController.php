<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // ① プロフィール画面（マイページ）の表示
    public function index()
    {
        $user = Auth::user();
        // 設計書に基づき、マイページ用のViewを返す
        return view('mypage', compact('user'));
    }

    // ② プロフィール編集画面の表示
    public function edit()
    {
        $user = Auth::user();
        // 現在のコード。compactでユーザー情報を渡せているのでOK！
        return view('auth.profile', compact('user'));
    }

    // ③ プロフィール情報の更新
    public function update(Request $request)
    {

        dd('ここまで到達しました！', $request->all()); // 送信ボタンを押した瞬間に、この中身が表示されれば通信は成功です
        // ... 既存の処理 ...


        // ...（あなたが書いた素晴らしい更新処理）...
        // 更新後は、元の場所ではなく「マイページ」へ戻してあげると親切です
        return redirect('/mypage')->with('message', 'プロフィールを更新しました');
    }
}
