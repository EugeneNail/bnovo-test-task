<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\StoreRequest;
use App\Http\Requests\Guest\UpdateRequest;
use App\Models\Country;
use App\Models\Guest;
use App\Services\Country\CountryExtractorInterface;
use App\Services\Guest\GuestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuestController extends Controller
{
    private CountryExtractorInterface $countryExtractor;

    private GuestRepositoryInterface $guestRepository;


    public function __construct(CountryExtractorInterface $countryExtractor, GuestRepositoryInterface $guestRepository)
    {
        $this->countryExtractor = $countryExtractor;
        $this->guestRepository = $guestRepository;
    }


    // Не добавлял проверку на соответствие кода страны из телефона с кодом страны, полученной из countryId
    // так как гость может пользоваться IP-телефонией или виртуальным номером
    public function store(StoreRequest $request)
    {
        $country = $this->countryExtractor->fromRequest($request);
        if ($country == null) {
            return response()->json('Country not found', Response::HTTP_NOT_FOUND);
        }

        $guest = $this->guestRepository->create($request->validated(), $country);
        return response()->json($guest->id, Response::HTTP_CREATED);
    }


    public function show(Guest $guest) {
        return response()->json($guest->load('country'));
    }


    public function destroy(Guest $guest) {
        $guest->delete();

        return response()->noContent();
    }


    public function update(UpdateRequest $request, Guest $guest) {
        $country = $this->countryExtractor->fromRequest($request);
        if ($country == null) {
            return response()->json('Country not found', Response::HTTP_NOT_FOUND);
        }

        $this->guestRepository->update($guest, $request->validated(), $country);

        return response()->noContent();
    }
}
