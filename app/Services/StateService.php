<?php

namespace App\Services;

use App\Models\State;

/**
 * Class StateService.
 */
class StateService
{
    public function __construct(protected State $state)
    {
    }

    public function fetchCountryStates(int $countryId): Object
    {
        return $this->state->where(['country_id' => $countryId])->get();
    }
}
