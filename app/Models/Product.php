<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','status','sort','discount_price','sell_price','slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Define the relationship with images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id');
    }
}
