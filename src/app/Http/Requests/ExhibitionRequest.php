<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'img_url'     => 'required|mimes:jpeg,png|max:5120', // 画像必須、形式指定
            'categories'  => 'required',                        // カテゴリー必須
            'condition'   => 'required',                        // 状態必須
            'name'        => 'required|max:255',               // 商品名必須
            'description' => 'required|max:255',               // 説明必須（ご要望通り255文字）
            'price'       => 'required|integer|min:0',         // 価格必須、数値、0以上
        ];
    }

    /**
     * 3. エラーメッセージ：日本語の案内
     */
    public function messages()
    {
        return [
            'img_url.required'    => '商品画像を選択してください',
            'img_url.mimes'       => '拡張子が.jpegもしくは.pngの画像を選択してください',
            'categories.required' => '商品のカテゴリーを選択してください',
            'condition.required'  => '商品の状態を選択してください',
            'name.required'       => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max'     => '商品説明は255文字以内で入力してください',
            'price.required'      => '商品価格を入力してください',
            'price.integer'       => '数値型で入力してください',
            'price.min'           => '0円以上で入力してください',
        ];
    }
}
