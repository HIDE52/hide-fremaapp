<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        $query = Item::with('order')->keywordSearch($keyword);

        if ($tab === 'mylist') {
            $items = $user ? $user->likeItems()->with('order')->keywordSearch($keyword)->get() : collect();
        } else {
            if ($user) {
                $query->where('user_id', '!=', $user->id);
            }
            $items = $query->get();
        }

        return view('item_index', compact('items', 'tab'));
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments', 'likes'])->findOrFail($item_id);
        return view('item_detail', compact('item'));
    }

    public function sell()
    {
        return view('item_sell');
    }
}

