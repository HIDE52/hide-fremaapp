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
        // ここは必ず true にしてください
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
            'name'        => 'required|max:255',
            'description' => 'required|max:1000',
            'price'       => 'required|integer|min:0',
            'condition'   => 'required',
            'categories'  => 'required|array',
            // 'required' を先頭に、その後に形式チェックを並べます
            'img_url'     => 'required|file|image|mimes:jpeg,png|max:2048',
            // 'img_url'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            // ここに日本語メッセージを直接書く
            'img_url.required'     => '商品画像を選択してください',
            'img_url.image'        => '指定されたファイルが画像ではありません',
            'img_url.mimes'        => '拡張子が.jpegもしくは.pngの画像を選択してください',
            'img_url.max'          => '画像サイズは2MB以内でアップロードしてください',
            'categories.required'  => '商品のカテゴリーを選択してください',
            'condition.required'   => '商品の状態を選択してください',
            'name.required'        => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'price.required'       => '商品価格を入力してください',
            'price.integer'        => '数値（整数）で入力してください',
            'price.min'            => '0円以上で入力してください',
        ];
    }
}
