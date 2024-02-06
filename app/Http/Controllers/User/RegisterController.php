<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use App\Services\User\AuthService;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
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
}