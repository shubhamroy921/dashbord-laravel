<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'status',
        'blocks',
    ];

    protected $casts = [
        'blocks' => 'json',
    ];
}
