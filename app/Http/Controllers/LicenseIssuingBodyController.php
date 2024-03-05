<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Services\LicenseIssuingBodyService;
use App\Http\Resources\LicenseIssuingBodyResource;

class LicenseIssuingBodyController extends Controller
{
    use ResponseTrait;
    public function fetchAllLicenseIssuingBodies(LicenseIssuingBodyService $service)
    {
        try {
            $countries = $service->fetchAllIssuingBodies();
            return  $this->successResponse('License Issuing Bodies fetched successfully', LicenseIssuingBodyResource::collection($countries));
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}
