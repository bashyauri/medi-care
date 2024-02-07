<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Utils
{

    /*
     ** TOKEN UTILS STARTS HERE
    */
    public static function setToken($key, $expiryMinutes)
    {
        $token = self::getCache($key);
        if (!$token) {
            $token = Str::random(6);
        }
        self::setCache($key, $token, $expiryMinutes);
        return $token;
    }
    /*
     ** TOKEN UTILS ENDS HERE
    */



    /*
     ** CACHE UTILS STARTS HERE
    */
    public static function setCache(string $name, mixed $value, int $expiryMinutes): void
    {
        cache()->put($name, $value, $expiryMinutes);
    }
    public static function getCache(string $name): mixed
    {
        return cache()->get($name);
    }
    public static function deleteCache(string $name): void
    {
        cache()->delete($name);
    }
    /*
     ** CACHE UTILS ENDS HERE
    */

    /*
     ** USER ACTIVITY UTILS
    */

    public static function addUserActivity($user, string $event, mixed $data = null, ?string $outcome = null): void
    {
        $user->activities()->create([
            'event' => $event,
            'outcome' => $outcome,
            'data' => json_encode($data),
        ]);
    }

    public static function addAuthUserActivity(string $event, mixed $data = null, ?string $outcome = null): void
    {
        self::addUserActivity(auth()->user(), $event, $data, $outcome);
    }
}