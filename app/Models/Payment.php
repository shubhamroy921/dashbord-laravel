<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'transaction_id',
        'payment_status',
        'response_msg',
        'providerReferenceId',
        'merchantOrderId',
        'checksum',
    ];
}
