<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Exceptions\CustomException;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\User\UserAddressService;
use App\Http\Resources\User\AddressResource;
use App\Http\Requests\User\Profile\UserAddressRequest;

class UserAddressController extends Controller
{
    use ResponseTrait;
    public function __construct(protected UserAddressService $userAddressService)
    {
    }
    public function index()
    {

        $user = auth()->user();

        $addresses = $user->userAddresses;
        if ($addresses->isEmpty()) {
            return  $this->successResponse("No address found", 204);
        }
        try {

            return $this->successResponse('Address Fetched', [
                'address' => new AddressResource($addresses),
            ]);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    public function store(UserAddressRequest $request)
    {
        try {

            $address = $this->userAddressService->store($request->validated());
            return $this->successResponse("Address created Successfully", [
                'address' => new AddressResource($address),
            ], 201);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
    public function show(string $id)
    {
        try {
            $user = auth()->user();
            $address = $user->userAddresses->where('id', $id)->firstOrFail();

            return $this->successResponse('Address Fetched', [
                'address' => new AddressResource($address),
            ]);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }
    public function update(UserAddressRequest $request,  $id)
    {
        $address = UserAddress::where('id', $id)->firstOrFail();
        try {
            $this->userAddressService->update($request->validated(), $id);
            return $this->successResponse("Address updated Successfully", [
                'address' => new AddressResource($address),
            ], 200);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            $this->userAddressService->destroy($id);
            return $this->successResponse("Content deleted", [], 204);
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
}
