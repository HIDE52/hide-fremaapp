<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class OrderController extends Controller
{
    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('item_purchase', compact('item', 'user'));
    }

    public function address_edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('address_edit', compact('user', 'item_id'));
    }

    public function address_update(AddressRequest $request, $item_id)
    {
        session([
            'shipping_address' => [
                'postcode' => $request->postcode,
                'address'  => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect()->route('item.purchase', ['item_id' => $item_id]);
    }

    public function buy(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $sessionAddress = session('shipping_address');
        $postcode = $sessionAddress['postcode'] ?? $request->postcode;
        $address  = $sessionAddress['address'] ?? $request->address;
        $building = $sessionAddress['building'] ?? $request->building;

        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout_session = Session::create([
            'payment_method_types' => [$request->payment_method === 'card' ? 'card' : 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('item.index'),
            'cancel_url' => route('item.purchase', ['item_id' => $item->id]),
        ]);

        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'price' => $item->price,
            'postcode' => $postcode,
            'address' => $address,
            'building' => $building,
            'payment_method' => $request->payment_method,
            'stripe_id' => $checkout_session->id,
            'status' => 'pending',
        ]);

        session()->forget('shipping_address');

        return redirect($checkout_session->url, 303);
    }
}
