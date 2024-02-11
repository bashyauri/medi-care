<?php

namespace App\Services\User;


use App\Traits\FileTrait;
use App\Utils\Utils;
use Illuminate\Support\Facades\DB;

/**
 * Class ProfileService.
 */
class ProfileService extends UserService
{
    use FileTrait;


    public function updateUserProfile($data)
    {
        DB::transaction(function () use ($data) {
            $this->updateUser($data);
            // Utils::addAuthUserActivity('User updated profile', $data);
        });
    }

    public function updateUser($data)
    {
        auth()->user()->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'],
        ]);
    }

    // public function updateInformation($data)
    // {
    //     $this->customerInformation->updateOrCreate(
    //         [
    //             'user_id' => auth()->id()
    //         ],
    //         [
    //             'gender' => $data['gender'],
    //             'date_of_birth' => $data['date_of_birth'],
    //             'username' => $data['username'],
    //             'user_id' => auth()->id()
    //         ]
    //     );
    // }

    // public function updateUserImage($data)
    // {
    //     $previousImage = auth()->user()->customerInformation->image;
    //     $filename = $this->uploadFile('user/image', $data['image']);

    //     auth()->user()->customerInformation()->update([
    //         'image' => $filename,
    //     ]);
    //     if ($previousImage) {
    //         $this->deleteFile($previousImage);
    //     }
    // }
}