<?php

namespace App\Services\Guest;

use App\Models\Country;
use App\Models\Guest;

interface GuestRepositoryInterface
{
    public function create(array $data, Country $country): Guest;

    public function update(Guest $guest, array $data, Country $country): void;
}
