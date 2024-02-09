<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\User\PasswordService;
use App\Http\Requests\User\Auth\ResetTokenRequest;
use App\Http\Requests\User\Auth\SendResetTokenRequest;
use App\Http\Requests\User\Auth\UpdatePasswordRequest;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use ResponseTrait;
    public function __construct(protected PasswordService $passwordService)
    {
    }

    public function forgotPassword(SendResetTokenRequest $request): Response
    {
        try {
            $this->passwordService->requestPasswordResetToken($request->validated());
            return $this->successResponse('Password Reset Token Successfully Sent To Your Email');
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    public function resetPassword(ResetTokenRequest $request): Response
    {
        try {
            $this->passwordService->resetPassword($request->validated());
            return $this->successResponse('Password updated Successfully');
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), 401);
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
    public function updateUserPassword(UpdatePasswordRequest $request): Response
    {

        try {
            $this->passwordService->updateUserPassword($request->validated());
            return $this->successResponse('User Password updated Successfully');
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), 401);
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            return $this->errorResponse("Something went wrong");
        }
    }
}
