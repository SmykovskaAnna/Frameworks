<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionExhibit extends Model
{
    protected $fillable = [
        'display_order',
        'exhibition_id',
        'exhibit_id',
    ];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function exhibit(): BelongsTo
    {
        return $this->belongsTo(Exhibit::class);
    }
}
