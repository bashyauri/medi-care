<?php

namespace App\Http\Controllers\Frontend;



use Exception;
use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UpdateVendorServiceRequest;
use App\Services\Vendor\VendorServicesService;
use App\Http\Requests\Vendor\VendorServiceRequest;
use App\Http\Resources\Vendor\VendorServiceResource;
use App\Models\VendorService;

class VendorServicesController extends Controller
{

    use ResponseTrait;

    public function __construct(protected VendorServicesService $vendorService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $services = $vendor->vendorServices;
        if ($services->isEmpty()) {
            return  $this->successResponse("No Vendor Service found", 204);
        }
        try {

            return $this->successResponse('Sevices Fetched', [
                'data' => new VendorServiceResource($services),
            ]);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorServiceRequest $request)
    {
        if (auth()->user()->role === 'vendor') {
            return redirect()->back();
        }
        try {

            $vendorService = $this->vendorService->store($request, $request->validated());
            return $this->successResponse("Vendor Service Added", [
                'vendorService' => new VendorServiceResource($vendorService),
            ], 201);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $vendor = auth()->user()->vendor;
            $vendorService = $vendor->vendorServices->where('id', $id)->firstOrFail();

            return $this->successResponse('Vendor Service Fetched', [
                'data' => new VendorServiceResource($vendorService),
            ]);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorServiceRequest $request, string $id)
    {
        $vendorService = VendorService::where('id', $id)->firstOrFail();
        try {
            $this->vendorService->update($request->all(), $id, $request, $vendorService);
            return $this->successResponse("Vendor Service updated Successfully", [
                'data' => new VendorServiceResource($vendorService),
            ], 200);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->vendorService->destroy($id);
            return $this->successResponse("Content deleted", [], 204);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
}
