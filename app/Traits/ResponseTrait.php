<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{
    public function successResponse(string $message, mixed $data = [], int $status = 200): Response
    {
        return response([
            "success" => true,
            "message" => $message,
            "data" => $data,
        ], $status);
    }
    public function errorResponse(string $message = "Something went wrong", int $status = 500): Response
    {
        return response([
            "success" => false,
            "message" => $message,
        ], $status);
    }
    public function resourceCreated(mixed $data = [], string $message = "Resource created", $status = 201): Response
    {
        return response([
            "success" => true,
            "message" => $message,
        ], $status);
    }
    public function serverError(string $message = "Internal Server Error")
    {
        return $this->errorResponse($message);
    }
}