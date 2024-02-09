<?php

namespace App\Services\User;

use App\Enums\TokenTypeEnum;
use App\Utils\Utils;

use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

use Illuminate\Support\Facades\Hash;
use App\Notifications\User\Auth\ResetPasswordNotification;


/**
 * Class PasswordService.
 */
class PasswordService
{
    public function __construct(protected UserService $userService)
    {
    }

    public function requestPasswordResetToken(array $data): void
    {
        $user = $this->userService->getUserBy(['email' => $data['email']]);

        $token = Utils::setToken(TokenTypeEnum::PASSWORD_RESET . $data['email'], 600);
        // Utils::addUserActivity($user, 'Requested Password Reset Token', $data);
        //RequestPasswordResetTokenNotification
        $user->notify(new ResetPasswordNotification($token));
    }

    // public function resetPassword(array $data)
    // {
    //     $token = Utils::getCache(TokenTypeEnum::PASSWORD_RESET.$data['email']);
    //     if (!$token) {
    //         throw new CustomException("Token expired. Please request for a new password reset token");
    //     }

    //     if ($token !== $data['token']) {
    //         throw new CustomException("Invalid token");
    //     }

    //     DB::transaction(function () use($data)
    //     {
    //         $user = $this->userService->getUserBy(['email' => $data['email']]);
    //         $user->update([
    //             'password' => Hash::make($data['password'])
    //         ]);

    //         Utils::addUserActivity($user,'Reset Password Using Reset Token', $data);

    //         Utils::deleteCache(TokenTypeEnum::PASSWORD_RESET.$data['email']);
    //         $user->notify(new ResetPasswordNotification("Notification Successful")); //PasswordResetNotification
    //     });
    // }
    // public function updateUserPassword(array $data) : void
    // {
    //     DB::transaction(function () use($data)
    //     {
    //         $user = auth()->user();

    //         if (Hash::check($data['current_password'], $user->password)) {
    //             $user->update([ 'password' => $data['new_password']]);
    //         }
    //         else{
    //             throw new CustomException("You entered an invalid old password");
    //         }

    //         Utils::addAuthUserActivity('Password Updated', $data);
    //     });

    // }
}