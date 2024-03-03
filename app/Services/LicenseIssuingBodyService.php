<?php

namespace App\Services;

use App\Models\LicenseIssuingBody;

/**
 * Class LicenseIssuingBodyService.
 */
class LicenseIssuingBodyService
{
    public function  __construct(protected LicenseIssuingBody $body)
    {
    }
    public function fetchAllIssuingBodies()
    {
        return $this->body->all();
    }
}
