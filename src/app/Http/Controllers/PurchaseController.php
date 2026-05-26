<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;


class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item=Item::findOrFail($item_id);

        if ($item->status !== '販売中') {
        return redirect('/');
    }
        $address=Auth::user()->addresses()->first();
        return view('purchases.index', compact('item', 'item_id', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        if ($request->payment_method === 'カード払い') {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $item = Item::findOrFail($item_id);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/purchase/success/' . $item_id),
            'cancel_url' => url('/purchase/' . $item_id),
        ]);

        return redirect($session->url);
    }

    Purchase::create([
        'user_id' => Auth::id(),
        'item_id' => $item_id,
        'payment_method' => $request->payment_method,
    ]);
    $item = Item::findOrFail($item_id);
    $item->update(['status' => 'sold_out']);

    return redirect('/');
}

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $address = Auth::user()->addresses()->first();
        return view('purchases.address', compact('item', 'item_id'))
            ->with([
                'postal_code' => $address->postal_code ?? '',
                'address' => $address->address ?? '',
                'building' => $address->building ?? '',
            ]);
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
    $user = Auth::user();
    $user->addresses()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]
    );
    return redirect()->route('purchase.index', ['item_id' => $item_id]);
    }

    public function success($item_id)
    {
        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'payment_method' => 'カード払い',
    ]);
        $item = Item::findOrFail($item_id);
        $item->update(['status' => 'sold_out']);

    return redirect('/');
}
}