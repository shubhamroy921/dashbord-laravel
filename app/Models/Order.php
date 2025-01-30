<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'transaction_id', // If you store this in the order table
    ];

    // If needed, define relationships, e.g., Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
