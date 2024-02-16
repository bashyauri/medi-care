<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\LgaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LgaResource;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class LgaController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected LgaService $lgaService,
    ) {
    }

    public function fetchStateLgas(int $stateId): Response
    {
        try {
            $lgas = $this->lgaService->fetchStateLgas($stateId);
            return  $this->successResponse('Lgas fetched successfully!', LgaResource::collection($lgas));
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}