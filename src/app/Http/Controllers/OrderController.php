<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
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

        return DB::transaction(function () use ($request, $item, $user, $postcode, $address, $building) {
            try {
                $stripe_id = null;
                $status = 'succeeded';

                if ($request->payment_method === 'card') {
                    Stripe::setApiKey(config('services.stripe.secret'));

                    $intent = PaymentIntent::create([
                        'amount' => $item->price,
                        'currency' => 'jpy',
                        'payment_method_data' => [
                            'type' => 'card',
                            'card' => ['token' => $request->stripeToken],
                        ],
                        'confirm' => true,
                        'description' => '商品購入: ' . $item->name,
                        'off_session' => true,
                    ]);

                    $stripe_id = $intent->id;
                    $status = $intent->status;
                }

                Order::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'price' => $item->price,
                    'postcode' => $postcode,
                    'address' => $address,
                    'building' => $building,
                    'payment_method' => $request->payment_method,
                    'stripe_id' => $stripe_id,
                    'status' => $status,
                ]);

                session()->forget('shipping_address');

                return redirect()->route('item.index')->with('message', '購入が完了しました');
            } catch (\Exception $e) {
                return back()->with('error', '決済に失敗しました: ' . $e->getMessage());
            }
        });
    }
}
