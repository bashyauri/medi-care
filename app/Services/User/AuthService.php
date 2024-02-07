<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\Utils;
use App\Enums\TokenTypeEnum;

use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Notifications\UserRegisteredNotification;
use App\Notifications\User\Auth\UserWelcomeNotification;

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
    public function verifyEmailToken($data)
    {
        $token = Utils::getCache(TokenTypeEnum::EMAIL_VERIFICATION . $data['email']);
        if (!$token) {
            throw new CustomException("Token expired. Please request for a new password reset token");
        }

        if ($token !== $data['token']) {
            throw new CustomException("Invalid token");
        }

        DB::transaction(function () use ($data) {
            $user = $this->user->firstWhere(['email' => $data['email']]);
            if ($user->status != UserStatusEnum::REGISTERED) {
                throw new CustomException("User email address already verified");
            }
            $user->update([
                'status' => UserStatusEnum::VERIFIED
            ]);

            // Utils::addUserActivity($user, 'User verifies email address', $data);

            Utils::deleteCache(TokenTypeEnum::EMAIL_VERIFICATION . $data['email']);
            $user->notify(new UserWelcomeNotification());
        });
    }
}