<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->select('id', 'name', 'price', 'stock', 'reference');
    }
}
