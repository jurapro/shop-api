<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    public function products()
    {
        return $this->hasMany(ProductOrder::class);
    }

    static function createOrder()
    {
        $order = Order::create([
            'user_id' => Auth()->user()->id,
        ]);
        $productsFromCart = ProductCart::where(['user_id' => $order->user_id])->get();
        foreach ($productsFromCart as $productInCart)
        {
            ProductOrder::create([
                'product_id' => $productInCart->product_id,
                'order_id' => $order->id,
                'price' => $productInCart->product->price,
            ]);
            $productInCart->delete();
        }
        return $order;
    }
}
