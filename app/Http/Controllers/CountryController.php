<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Services\CountryService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected CountryService $countryService,
    ) {
    }
    public function fetchAllCountries(): Response
    {

        try {
            $countries = $this->countryService->fetchAllCountries();
            return  $this->successResponse('Countries fetched successfully', CountryResource::collection($countries));
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}
