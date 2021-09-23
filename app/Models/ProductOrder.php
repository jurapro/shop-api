<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'products_order';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
