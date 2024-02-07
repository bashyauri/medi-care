<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\Utils;
use App\Enums\TokenTypeEnum;

use App\Enums\UserStatusEnum;
use App\Notifications\UserRegisteredNotification;

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
        $token = rand(111111, 999999);
        $token = Utils::setToken(TokenTypeEnum::EMAIL_VERIFICATION . $data['email'], 3600);
        $user->notify(new UserRegisteredNotification($token));

        // Utils::addUserActivity($user, 'User register', $data);
        return $user;
    }
}