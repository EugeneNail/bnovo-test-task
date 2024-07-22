<?php

namespace App\Services\Guest;

use App\Models\Country;
use App\Models\Guest;

class GuestRepository implements GuestRepositoryInterface
{
    public function create(array $data, Country $country): Guest
    {
        $guest = new Guest([
            'name' => $data['name'],
            'last_name' => $data['lastName'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phoneNumber'],
        ]);
        $country->guest()->save($guest);
        $guest->save();

        return $guest;
    }


    public function update(Guest $guest, array $data, Country $country): void {
        $guest->fill([
            'name' => $data['name'],
            'last_name' => $data['lastName'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phoneNumber'],
        ]);
        $country->guest()->save($guest);
        $guest->save();
    }
}
