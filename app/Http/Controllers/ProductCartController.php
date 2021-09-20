<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;


class ProductCartController extends Controller
{
    public function addProduct(Product $product)
    {
        $productCart = ProductCart::create([
            'user_id' => Auth()->id(),
            'product_id' => $product->id
        ]);
        return $productCart;
    }
}
