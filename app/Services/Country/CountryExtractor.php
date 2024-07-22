<?php

namespace App\Services\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryExtractor implements CountryExtractorInterface
{
    public function fromRequest(Request $request): ?Country
    {
        if ($request->has('countryId')) {
            return Country::find($request->countryId);
        }

        return $this->fromPhoneNumber($request->phoneNumber);
    }


    public function fromPhoneNumber(string $phoneNumber): ?Country
    {
        if (str_starts_with($phoneNumber, '+')) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        foreach (Country::pluck('code') as $code) {
            if (str_starts_with($phoneNumber, $code)) {
                return Country::where('code', $code)->first();
            }
        }

        return null;
    }
}
