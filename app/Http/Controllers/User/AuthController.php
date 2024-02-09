<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\User\AuthService;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Http\Requests\User\Auth\VerifyEmailTokenRequest;


class AuthController extends Controller
{
    use ResponseTrait;
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            if ($token = $this->authService->login($request->validated())) {
                return $this->successResponse('Login Success', [
                    'token' => $token,
                    'user' => new UserResource(auth()->user()),
                ]);
            } else {
                return $this->errorResponse("Invalid Login", 401);
            }
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $this->authService->register($request->validated());
            return $this->resourceCreated(new UserResource($data), 'Registeration Successful. Please check your email for verification token');
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    public function verifyEmailToken(VerifyEmailTokenRequest $request)
    {
        try {
            $this->authService->verifyEmailToken($request->validated());
            return $this->successResponse('Email verified successfully');
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }

    // public function requestEmailVerificationToken(SendResetTokenRequest $request)
    // {
    //     try {
    //         $this->authService->requestEmailVerificationToken($request->validated());
    //         return $this->successResponse('Email verification token sent successfully');
    //     } catch (CustomException $ex) {
    //         return $this->errorResponse($ex->getMessage(), 401);
    //     } catch (Exception $ex) {
    //         Log::error($ex->getMessage());
    //         return $this->errorResponse("Something went wrong", 401);
    //     }
    // }
    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);
            return $this->successResponse('Successfully logged out');
        } catch (CustomException $ex) {
            return $this->errorResponse($ex->getMessage(), 401);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->errorResponse("Something went wrong", 401);
        }
    }
}
