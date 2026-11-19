<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibit extends Model
{
    protected $fillable = [
        'name',
        'description',
        'author',
        'creation_date',
    ];

    public function exhibitionExhibits(): HasMany
    {
        return $this->hasMany(ExhibitionExhibit::class);
    }
}
