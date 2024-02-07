<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\Utils;

/**
 * Class AuthService.
 */
class AuthService
{
    public function __construct(protected User $user)
    {
    }
    public function register($data)
    {
        $user = $this->user->create($data);
        $data['token'] = $user->createToken($data['email'])->accessToken;
        return $user;
    }
}