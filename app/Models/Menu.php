<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order_number');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order_number');
    }

    /**
     * Get menu items organized in a tree structure
     */
    public function getTreeAttribute(): array
    {
        return $this->items()
            ->with('children')
            ->orderBy('order_number')
            ->get()
            ->toArray();
    }
}
