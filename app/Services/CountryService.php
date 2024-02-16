<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CountryService.
 */
class CountryService
{
    public function  __construct(protected Country $country)
    {
    }
    public function fetchAllCountries(): Collection
    {
        return $this->country->all();
    }
}
