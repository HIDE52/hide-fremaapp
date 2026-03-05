<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// サイトのトップ（/）にアクセスが来たら、ItemControllerのindexアクションを呼ぶ
Route::get('/', [ItemController::class, 'index']);
Route::middleware('auth')->group(function () {
    // プロフィール編集画面の表示(GET)と更新(POST)
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
});