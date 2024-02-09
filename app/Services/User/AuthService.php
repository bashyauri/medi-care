<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\Utils;
use App\Enums\TokenTypeEnum;

use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserRegisteredNotification;
use App\Notifications\User\Auth\UserWelcomeNotification;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/**
 * Class AuthService.
 */
class AuthService
{
    public function __construct(protected User $user)
    {
    }
    public function login(array $data)
    {
        if (auth()->attempt($data)) {
            // Utils::addAuthUserActivity('User login', $data);
            $user = User::find(Auth::user()->id);
            return   $user->createToken(config('services.auth.token'))->accessToken;
        }
    }
    public function register($data)
    {
        $user = $this->user->create($data);
        $token = rand(111111, 999999);
        $token = Utils::setToken(TokenTypeEnum::EMAIL_VERIFICATION . $data['email'], 3600);
        Log::info('Token generated and stored:', ['email' => $data['email'], 'token' => $token, 'expiryMinutes' => 3600]);
        $user->notify(new UserRegisteredNotification($token));

        // Utils::addUserActivity($user, 'User register', $data);
        return $user;
    }
    public function verifyEmailToken($data)
    {
        $token = Utils::getCache(TokenTypeEnum::EMAIL_VERIFICATION . $data['email']);
        Log::info('Token retrieved for verification:', ['email' => $data['email'], 'token' => $token]);
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
    public function logout($request)
    {
        return $request->user()->tokens()->delete();
    }
}
