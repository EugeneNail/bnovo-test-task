<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];


    public function guest(): BelongsTo {
        return $this->belongsTo(Guest::class);
    }
}
