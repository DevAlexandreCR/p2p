<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Payer extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'document_type',
        'name',
        'last_name',
        'email',
        'phone'
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
