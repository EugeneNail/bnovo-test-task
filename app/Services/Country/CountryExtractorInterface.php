<?php

namespace App\Services\Country;

use App\Models\Country;
use Illuminate\Http\Request;

interface CountryExtractorInterface
{
    public function fromRequest(Request $request): ?Country;

    public function fromPhoneNumber(string $phoneNumber): ?Country;
}
