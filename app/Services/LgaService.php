<?php

namespace App\Services;

use App\Models\Lga;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LgaService.
 */
class LgaService
{
    public function __construct(
        protected Lga $lga
    ) {
    }
    public function fetchStateLgas(int $stateId): Collection
    {
        return $this->lga->where(['state_id' => $stateId])->get();
    }
}
