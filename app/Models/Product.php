<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'description',
        'stock',
        'price',
        'image'
    ];

    public function scopeName(Builder $query, ?string $name): Builder
    {
        return $query->select('name', 'reference', 'stock', 'description', 'price', 'image')
            ->where('name', 'like', '%' . $name . '%');
    }

    public function scopeReference(Builder $query, ?string $reference): Builder
    {
        return $query->select('name', 'reference', 'stock', 'description', 'price', 'image')
            ->where('reference', 'like', '%' . $reference . '%');
    }
}
