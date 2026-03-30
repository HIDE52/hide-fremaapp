<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            // 1. 郵便番号：必須 ＋ ハイフンありの8文字
            'postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            // 2. 住所：必須
            'address'  => ['required'],
            // 3. 建物名：任意（空でもOK）
            'building' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex'    => '郵便番号はハイフンありの8文字で入力してください（例: 123-4567）',
            'address.required'  => '住所を入力してください',
        ];
    }
}
