<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\UpdateProfileRequest;
use App\Repositories\DocterRepository;
use App\Repositories\SubdistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    private $subdistrictRepository, $userRepository, $docterRepository;
    /**
     * Class constructor.
     */
    public function __construct(SubdistrictRepository $subdistrictRepository, UserRepository $userRepository, DocterRepository $docterRepository)
    {
        $this->subdistrictRepository = $subdistrictRepository;
        $this->userRepository = $userRepository;
        $this->docterRepository = $docterRepository;
    }

    public function show()
    {
        $sessionUser = getDataUser();
        if (!isDocter()) {
            $user = $this->userRepository->getUserById($sessionUser->id);
        } else {
            $user = $this->docterRepository->getDocterById($sessionUser->id, getDataUser()->id);
        }
        return view('pages.user-profile', [
            "user" => $user,
            "subdistricts" => $this->subdistrictRepository->all()
        ]);
    }
    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            $photo = $updateProfileRequest->file('photo');

            $sessionUser = getDataUser();

            if (!isDocter()) {
                $user = $this->userRepository->getUserById($sessionUser->id,);
            } else {
                $user = $this->docterRepository->getDocterById($sessionUser->id, getDataUser()->id);
            }
            $input = $updateProfileRequest->only('name', 'email', 'phone', 'subdistrict_id');
            if (isDocter()) {
                $input['description'] = $updateProfileRequest->input('description');
                $input['address'] = $updateProfileRequest->input('address');
            }
            if ($updateProfileRequest->has('password')) {
                $input['password'] = bcrypt($updateProfileRequest->input('password'));
            }
            if ($photo) {
                $pathDelete = $user->photo;
                if ($pathDelete !== null) {
                    Storage::delete($pathDelete);
                }
                $path = Storage::disk('public')->put('images/users', $photo);
                $input['photo'] = 'public/' . $path;
            }

            $user->update($input);
            return back()->with('success', 'Profile successfully updated');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
