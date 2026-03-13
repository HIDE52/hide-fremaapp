<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description',
        'brand_name',
        'condition',
        'img_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * orderリレーション: 商品と注文の紐付け（工程④のSold判定で使います）
     * 根拠: 商品一覧で Sold ラベルを出すために、注文データが存在するかを確認するため
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }


}
