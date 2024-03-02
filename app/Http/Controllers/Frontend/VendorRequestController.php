<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Traits\ResponseTrait;
use App\Exceptions\CustomException;

use App\Http\Controllers\Controller;

use App\Http\Resources\Vendor\VendorResource;
use App\Services\Vendor\VendorService;
use App\Http\Requests\Vendor\UserVendorRequest as VendorUserVendorRequest;

class VendorRequestController extends Controller
{
    use ResponseTrait;
    public function __construct(protected VendorService $vendorService)
    {
    }
    public function store(VendorUserVendorRequest $request)
    {
        if (auth()->user()->role === 'vendor') {
            return redirect()->back();
        }
        try {

            $vendor = $this->vendorService->requestVendor($request, $request->validated());
            return $this->successResponse("Vendor created", [
                'vendor' => new VendorResource($vendor),
            ], 201);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
}