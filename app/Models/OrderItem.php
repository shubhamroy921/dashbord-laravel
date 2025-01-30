<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    // Allow mass assignment for these fields
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'images'
    ];

    protected $guarded = [];


    // Define relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
