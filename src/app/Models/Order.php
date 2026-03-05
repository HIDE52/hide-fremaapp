<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'price',
        'postcode',
        'address',
        'building',
        'payment_method',
        'stripe_id',
        'status',
    ];

    /**
     * この注文をしたユーザーを取得（多対1）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この注文の対象となった商品を取得（多対1）
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
