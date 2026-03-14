<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile_edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return redirect()->route('mypage.profile')->with('message', 'プロフィールを更新しました');
    }

    public function address_edit()
    {
        $user = Auth::user();
        return view('mypage.address_edit', compact('user'));
    }
}
