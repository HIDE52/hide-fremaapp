<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'img_url',
        'postcode',
        'address',
        'building',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * likeItemsリレーション: ユーザーが「いいね」した商品の一覧を取得する（マイリスト用）
     * 視点：1人のユーザーはたくさんの商品に「いいね」できます
     * 「user_id」と「item_id」を記録した「likes」テーブル（中間テーブル）を通じて
     * 繋がっている items テーブルのデータを持ってきます。
     */
    public function likeItems()
    {
        // belongsToMany(相手のモデル, 中間テーブル名)
        // メソッド名を likes ではなく likeItems とすることで「いいねした商品」であることが明確になります
        return $this->belongsToMany(Item::class, 'likes');
    }
}
