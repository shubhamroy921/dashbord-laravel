<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    // Specify the table name (optional if the table name is 'images')
   // protected $table = 'product_images';

    // The attributes that are mass assignable
    protected $fillable = [
        'product_id',
        'path',
        'alt',
    ];

    // Define the inverse of the relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
