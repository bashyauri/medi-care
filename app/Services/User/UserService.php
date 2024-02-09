<?php

namespace App\Services\User;

use App\Models\CustomerInformation;
use App\Models\User;

/**
 * Class UserService.
 */
class UserService
{
    public function __construct(protected User $user)
    {
        //
    }

    public function getUserBy($param): User
    {
        return User::where($param)->first();
    }
}
