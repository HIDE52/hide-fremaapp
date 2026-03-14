<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // マスアサインメント対策：保存を許可する項目
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description',
        'brand_name',
        'condition',
        'img_url'
    ];

    // --- リレーション定義 ---

    // 持ち主（出品者）とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 売却済み判定用の注文リレーション
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    // いいね機能：中間テーブル likes を経由
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // カテゴリー機能：中間テーブル category_item を経由
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    // コメント機能
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // --- 【新規追加】検索ロジック（スコープ） ---

    /**
     * 商品名による部分一致検索のスコープ
     * 案①：教科書通りの「ローカルスコープ」の書き方です。
     * コントローラー側で Item::keywordSearch('文字') と呼び出せるようになります。
     */
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            // 商品名（name）カラムに対して、部分一致検索を行う（根拠：FN016-2）
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
