<?php

namespace App\Http\Controllers\Frontend;

use Exception;

use App\Traits\ResponseTrait;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\VendorAddressRequest;
use App\Http\Resources\Vendor\VendorAddressResource;

use App\Services\Vendor\VendorAddressService;

class VendorAddressController extends Controller
{
    use ResponseTrait;
    public function __construct(protected VendorAddressService $vendorAddressService)
    {
    }
    public function index()
    {
        $user = auth()->user();

        $vendorAddress = $user->vendor->vendorAddress;
        if (!$vendorAddress) {
            return  $this->successResponse("No Vendor address found", 204);
        }
        try {

            return $this->successResponse('Address Fetched', [
                'vendorAddress' => new VendorAddressResource($vendorAddress),
            ]);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }
    public function store(VendorAddressRequest $request)
    {
        try {

            $vendorAddress = $this->vendorAddressService->store($request->validated());
            return $this->successResponse("Address created Successfully", [
                'address' => new VendorAddressResource($vendorAddress),
            ], 201);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
}
