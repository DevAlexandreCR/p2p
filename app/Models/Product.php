<?php

namespace App\Models;

use App\Constants\Permissions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

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
        'slug',
        'enabled'
    ];

    /**
     * @return BelongsToMany
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

    /**
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    public function scopeName(Builder $query, ?string $name): Builder
    {
        return $query->select(
            'id',
            'name',
            'reference',
            'stock',
            'description',
            'price',
            'image',
            'slug',
            'enabled'
        )
            ->where('name', 'like', '%' . $name . '%');
    }

    /**
     * @param Builder $query
     * @param string|null $reference
     * @return Builder
     */
    public function scopeReference(Builder $query, ?string $reference): Builder
    {
        return $query->select(
            'id',
            'name',
            'reference',
            'stock',
            'description',
            'price',
            'image',
            'slug',
            'enabled'
        )
            ->where('reference', 'like', '%' . $reference . '%');
    }

    /**
     * @param Builder $query
     * @param string|null $orderBy
     * @param string|null $order
     * @return Builder
     */
    public function scopeOrder(Builder $query, ?string $orderBy, ?string $order): Builder
    {
        return $query->orderBy($orderBy ?? 'name', $order ?? 'asc');
    }

    /**
     * @param Builder $query
     * @param float|null $min
     * @param float|null $max
     * @return Builder|null
     */
    public function scopePrice(Builder $query, ?float $min, ?float $max): ?Builder
    {
        return $query->select(
            'id',
            'name',
            'reference',
            'stock',
            'description',
            'price',
            'image',
            'slug',
            'enabled'
        )
            ->whereBetween('price', [$min ?? 0, $max ?? config('app.max')]);
    }

    /**
     * @param Builder $query
     * @param bool|null $admin
     * @return Builder|null
     */
    public function scopeEnabled(Builder $query, ?bool $admin): ?Builder
    {
        if ($admin) {
            return null;
        }
        return $query->select(
            'id',
            'name',
            'reference',
            'stock',
            'description',
            'price',
            'image',
            'slug',
            'enabled'
        )
            ->where('enabled', true);
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
