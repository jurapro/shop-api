<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductCart;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function show()
    {
        return OrderResource::collection(Order::where('user_id', Auth()->user()->id)->get());
    }

    public function createOrder()
    {
        $order = Order::createOrder();

        return response()->json([
            'data' => [
                'order_id' =>  $order->id,
                'message' => 'Order is processed',
            ]
        ]);
    }
}
