<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'enabled');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    /**
     * return total cart value
     * @return string
     */
    public function getTotalCartAttribute(): string
    {
        $total = 0;
        $this->products()->each(function ($product) use (&$total) {
            $total += $product->price * $product->pivot->quantity;
        });

        return $total;
    }

    /**
     * return total products into cart
     * @return int
     */
    public function getTotalCartCountAttribute(): int
    {
        $total = 0;
        $this->products()->each(function ($product) use (&$total) {
            $total += $product->pivot->quantity;
        });

        return $total;
    }
}
