<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServicesResource;
use App\Services\AllServices;
use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    use ResponseTrait;
    public function fetchAllServices(AllServices $service)
    {
        try {
            $services = $service->fetchAllServices();
            return  $this->successResponse('All Services Fetched', ServicesResource::collection($services));
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}