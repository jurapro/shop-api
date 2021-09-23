<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Resources\ProductCartResource;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Support\Facades\Auth;


class ProductCartController extends Controller
{
    public function addProduct(Product $product)
    {
        ProductCart::create([
            'user_id' => Auth()->id(),
            'product_id' => $product->id
        ]);
        return response()->json([
            'data' => [
                'message' => 'Product add to card',
            ]
        ])->setStatusCode(201);
    }

    public function deleteProduct(ProductCart $product)
    {
        if (Auth()->user()->id !== $product->user_id)
        {
            throw new ApiException('403', 'Forbidden for you');
        }

        $product->delete();

        return response()->json([
            'data' => [
                "message" => "Product removed",
            ]
        ]);
    }

    public function show()
    {
        return ProductCartResource::collection(Auth()->user()->cart);
    }
}
