<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductOrder;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $productsIds = ProductOrder::where('order_id', $this->id)->pluck('product_id');
        return [
            'id' => $this->id,
            'product' => $productsIds,
            'order_price' => array_sum(Product::whereIn('id', $productsIds)->pluck('price')->toArray()),
        ];
    }
}
