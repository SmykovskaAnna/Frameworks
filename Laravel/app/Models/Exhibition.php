<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function exhibitionExhibits(): HasMany
    {
        return $this->hasMany(ExhibitionExhibit::class);
    }
}
