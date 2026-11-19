<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'purchase_date',
        'price',
        'ticket_type',
        'visitor_id',
        'exhibition_id',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}
