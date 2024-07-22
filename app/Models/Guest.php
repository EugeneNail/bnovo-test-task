<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone_number',
    ];


    public function country(): HasOne {
        return $this->hasOne(Country::class);
    }
}
