<?php

namespace App\Services\Guest;

use App\Models\Country;
use App\Models\Guest;

interface GuestRepositoryInterface
{
    public function save(array $data, Country $country): Guest;
}
