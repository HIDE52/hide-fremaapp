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
            'address.required'        => '配送先が選択されていません。プロフィール登録または住所変更を行ってください',
            'postcode.required'       => '郵便番号が登録されていません',
        ];
    }
}
