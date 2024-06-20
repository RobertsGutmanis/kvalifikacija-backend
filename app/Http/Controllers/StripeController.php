<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'data'=>$orders,
            'status'=>200
        ], 200);
    }

    public function checkout(Request $request){
        $stripe =  new \Stripe\StripeClient(config('stripe.sk'));

        $checkout_session = $stripe->checkout->sessions->create([
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => 499,
                            'currency' => 'eur',
                        ],
                        'display_name' => 'Piegāde 4.99eur',
                        'delivery_estimate' => [
                            'minimum' => [
                                'unit' => 'business_day',
                                'value' => 5,
                            ],
                            'maximum' => [
                                'unit' => 'business_day',
                                'value' => 5,
                            ],
                        ],
                    ],
                ],
            ],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'rgutmanis veikals',
                    ],
                    'unit_amount' => $request->totalPrice * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://fe.rgutmanis.com/checkout-success',
            'cancel_url' => 'https://fe.rgutmanis.com/',
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);

        Order::create([
            'user_id'=>Auth::user()->id,
            'tracking_number'=>rand(1000, 100000),
            'created_at'=>Carbon::today(),
            'delivered_at'=>Carbon::today(),
            'sum'=>$request->totalPrice,
            'delivery_method'=>$request->deliveryMethod
        ]);

        return  response()->json(['url'=>$checkout_session->url]);

    }
}
