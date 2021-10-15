<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductEditRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;


class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function add(ProductAddRequest $request)
    {
        $product = Product::create($request->all());
        return [
            'data' => [
                'id' => $product->id,
                'message' => 'Product added',
            ]
        ];
    }

    public function edit(Product $product, ProductEditRequest $request)
    {
        $product->update($request->all());
        return [
            'data' => $product,
        ];
    }

    public function delete(Product $product)
    {
        $product->delete();
        return [
            'data' => [
                'message' => 'Product removed',
            ]
        ];
    }
}
