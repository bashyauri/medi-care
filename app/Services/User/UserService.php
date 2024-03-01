<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\Vendor;
use App\Models\CustomerInformation;

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
