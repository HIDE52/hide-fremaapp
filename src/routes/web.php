<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ① 誰でもアクセスできるページ ---
// 根拠：基本設計書「商品一覧画面」
Route::get('/', [ItemController::class, 'index'])->name('item.index');

// 根拠：基本設計書「商品詳細画面」
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');


// --- ② ログイン必須のページ（authミドルウェア） ---
Route::middleware('auth')->group(function () {

    // 根拠：基本設計書「商品出品画面」
    Route::get('/sell', [ItemController::class, 'sell'])->name('item.sell');

    // 根拠：基本設計書「商品購入画面」
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');

    // 根拠：基本設計書「住所変更ページ」
    Route::get('/purchase/address/{item_id}', [UserController::class, 'address_edit'])->name('address.edit');

    // 根拠：基本設計書「プロフィール編集画面（取得・保存）」
    // 【修正ポイント】バイパスを廃止し、本来のパスと認証を有効にしました
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');

    // 根拠：基本設計書「プロフィール画面」
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
});
