<?php

namespace App\Services\User;

use App\Utils\Utils;
use App\Traits\FileTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;


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
        return auth()->user()->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
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

    public function updateUserImage($data)
    {



        if (File::exists(storage_path(auth()->user()->image))) {
            File::delete(storage_path(auth()->user()->image));


            $image = $data['image'];
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('uploads'), $imageName);

            $path = "/uploads/" . $imageName;
            Log::info($path);

            auth()->user()->update([
                'image' => $path,
            ]);
        }
    }
}
