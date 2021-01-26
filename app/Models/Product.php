<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'description',
        'stock',
        'price',
        'image',
        'slug'
    ];

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

    public function scopeName(Builder $query, ?string $name): Builder
    {
        return $query->select('id', 'name', 'reference', 'stock', 'description', 'price', 'image', 'slug')
            ->where('name', 'like', '%' . $name . '%');
    }

    public function scopeReference(Builder $query, ?string $reference): Builder
    {
        return $query->select('id', 'name', 'reference', 'stock', 'description', 'price', 'image', 'slug')
            ->where('reference', 'like', '%' . $reference . '%');
    }

    /**
     * get total price with quantity into cart
     * @return string
     */
    public function getTotalPriceAttribute(): string
    {
        return number_format($this->pivot->quantity * $this->price);
    }
}
