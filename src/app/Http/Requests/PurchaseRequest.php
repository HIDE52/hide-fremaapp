<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_method' => 'required',
            'address' => 'required',
            'postcode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'address.required' => '配送先住所が登録または入力されていません',
            'postcode.required' => '郵便番号が登録または入力されていません',
        ];
    }
}
