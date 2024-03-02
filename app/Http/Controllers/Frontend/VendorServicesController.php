<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\VendorServiceRequest;

use App\Http\Resources\Vendor\VendorServiceResource;
use App\Services\Vendor\VendorServicesService;
use App\Traits\ResponseTrait;

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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}