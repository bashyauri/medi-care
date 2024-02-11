<?php

namespace App\Http\Controllers\Backend;



use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Services\User\ProfileService;
use App\Traits\ResponseTrait;

class ProfileController extends Controller
{
    use ResponseTrait;
    public function __construct(protected ProfileService $profileService)
    {
    }
    public function index()
    {
        return response()->json([
            'message' => 'You are in User'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {

        try {
            $this->profileService->updateUserProfile($request->validated());
            return $this->successResponse("Profile successfully updated");
        } catch (Exception $ex) {
            return $this->errorResponse($ex);
        }
        // $user = Auth::user();

        // if ($request->hasFile('image')) {
        //     if (File::exists(public_path($user->image))) {
        //         File::delete(public_path($user->image));
        //     }

        //     $image = $request->image;
        //     $imageName = rand() . '_' . $image->getClientOriginalName();
        //     $image->move(public_path('uploads'), $imageName);

        //     $path = "/uploads/" . $imageName;

        //     $user->image = $path;
        // }

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->save();

        // toastr()->success('Profile Updated Successfully!');
        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
