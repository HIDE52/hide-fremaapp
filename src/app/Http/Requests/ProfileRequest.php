<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * ① 誰にこのチェックを許可するか
     */
    public function authorize()
    {
        return true;
    }

    /**
     * ② バリデーションルール（校則）の定義
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'postcode' => 'required|regex:/^\d{3}-\d{4}$/',
            'address'   => 'required|string|max:255',
            'building'  => 'nullable|string|max:255',
            // 【修正箇所】順番を入れ替えました
            'img_url'   => 'nullable|mimes:jpeg,png|image|max:2048',
        ];
    }

    /**
     * ③ エラーメッセージの日本語化
     */
    public function messages()
    {
        return [
            'name.required'      => 'お名前を入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex'    => '郵便番号は「000-0000」の形式で入力してください',
            'address.required'   => '住所を入力してください',
            'img_url.image'      => '指定されたファイルが画像ではありません',
            'img_url.mimes'      => '画像の形式はjpegまたはpngのみ有効です',
        ];
    }
}
