<?php

namespace App\Http\Controllers\Backend;



use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Services\User\ProfileService;


use App\Http\Requests\User\Profile\UpdateProfileRequest;
use App\Http\Requests\User\Profile\UpdateUserImageRequest;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    use ResponseTrait;
    public function __construct(protected ProfileService $profileService)
    {
    }
    public function index()
    {
        return response()->json([
            'message' => 'You are in User'
        ], 200);
    }


    public function updateUserProfile(UpdateProfileRequest $request)
    {


        try {
            $this->profileService->updateUserProfile($request->validated());
            return $this->successResponse("Profile successfully updated", [], 204);
        } catch (Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function updateUserImage(UpdateUserImageRequest $request)
    {


        try {

            $this->profileService->updateUserImage($request->validated());
            return $this->successResponse("Profile image successfully updated");
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage());
        } catch (Exception $ex) {
            return $this->errorResponse("Something went wrong " . $ex->getMessage());
        }
    }
}
