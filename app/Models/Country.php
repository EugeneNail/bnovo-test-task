<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];


    public function guest(): HasMany {
        return $this->hasMany(Guest::class);
    }
}
