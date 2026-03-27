<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

Route::middleware('auth')->group(function () {
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::get('/purchase/{item_id}', [UserController::class, 'purchase'])->name('item.purchase');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address_edit'])->name('address.edit');

    Route::post('/item/{item_id}/like', [LikeController::class, 'store'])->name('like.store');

    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});
