<?php

namespace App\Services;

use App\Models\Service;

/**
 * Class AllServices.
 */
class AllServices
{
    public function  __construct(protected Service $service)
    {
    }
    public function fetchAllServices()
    {
        return $this->service->all();
    }
}