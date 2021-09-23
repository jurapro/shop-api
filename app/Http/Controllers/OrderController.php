<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductCart;

class OrderController extends Controller
{
    public function newOrder()
    {
        $order = new Order([
            'user_id' => Auth()->user()->id,
        ]);
        $order->save();

        $productsFromCart = ProductCart::where(['user_id' => $order->user_id])->get();
        foreach ($productsFromCart as $productInCart)
        {
            $prodInOrder = new ProductOrder([
                'product_id' => $productInCart->product_id,
                'order_id' => $order->id,
                'price' => $productInCart->product->price,
            ]);
            $prodInOrder->save();
            $productInCart->delete();
        }

        return response()->json([
            'data' => [
                'order_id' =>  $order->id,
                'message' => 'Order is processed',
            ]
        ]);
    }
}
