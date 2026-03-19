<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page');

        return view('mypage.profile', compact('user', 'page'));
    }

    public function purchase(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $address = session('new_address', $user->address);
        $postcode = session('new_postcode', $user->postcode);
        $building = session('new_building', $user->building);

        return view('item_purchase', compact('item', 'user', 'address', 'postcode', 'building'));
    }

    public function buy(Request $request, $item_id)
    {
        return redirect()->route('item.index')->with('message', '購入が完了しました');
    }
}
