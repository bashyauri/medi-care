<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\StateService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\StateResource;
use App\Traits\ResponseTrait;

class StateController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected StateService $stateService
    ) {
    }

    public function fetchCountryStates($countryId): Response
    {

        try {
            $states = $this->stateService->fetchCountryStates($countryId);
            return  $this->successResponse('States fetched successfully!', StateResource::collection($states));
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}
