<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Requests\RegisterRequest; // ★これを追記（作成したRequestを読み込む）

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // ① 先ほど作った RegisterRequest（特注のルールブック）を準備
        $registerRequest = new RegisterRequest();

        // ② Validatorに「ルール」と「日本語メッセージ」を渡す形に書き換え
        Validator::make($input, $registerRequest->rules(), $registerRequest->messages())->validate();

        // ③ 保存処理（ここはそのまま）
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
