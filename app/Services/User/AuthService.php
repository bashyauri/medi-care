<?php

namespace App\Services\User;

use App\Models\User;

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
        $data['token'] = $user->createToken(rand(111111, 999999))->accessToken;
        return $user;
    }
}