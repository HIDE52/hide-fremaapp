<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController; // 追加

// 誰でも見れるページ
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// ログイン中のみ許可するページ（1つにまとめます）
Route::middleware('auth')->group(function () {
    // 出品
    Route::get('/sell', [ItemController::class, 'sell'])->name('item.sell');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // マイページ・購入
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::get('/purchase/{item_id}', [UserController::class, 'purchase'])->name('item.purchase');

    // プロフィール・住所変更
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address_edit'])->name('address.edit');

    // 【整理ポイント】いいね（入れ子を解消してここに並べます）
    Route::post('/item/{item_id}/like', [LikeController::class, 'store'])->name('like.store');

    // 【今回追加】コメント（同じくログイン必須なのでここに並べます）
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});
