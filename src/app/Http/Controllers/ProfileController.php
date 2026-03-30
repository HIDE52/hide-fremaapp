<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        $form = $request->validated();

        if ($request->hasFile('img_url')) {
            if ($user->img_url) {
                Storage::disk('public')->delete($user->img_url);
            }
            $path = $request->file('img_url')->store('profiles', 'public');
            $form['img_url'] = $path;
        }

        $user->update($form);

        return redirect()->back()->with('message', 'プロフィールを更新しました');
    }
    public function address_edit($item_id)
    {
        $user = Auth::user();
        return view('mypage.address_edit', compact('user', 'item_id'));
    }
}
