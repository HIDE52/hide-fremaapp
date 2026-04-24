<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $items = ($page === 'buy') ? $user->orderedItems : $user->items;

        return view('mypage.profile', compact('user', 'page', 'items'));
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
}
