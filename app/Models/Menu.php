<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'link', 'sort','status'];

    /**
     * Get the menu items for the menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItems::class);
    }
}
