<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('public/profiles');
            $user->img_url = basename($path);
        }

        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        $user->save();
        return redirect()->back()->with('message', 'プロフィールを更新しました');
    }
}
