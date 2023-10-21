<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Repositories\DocterRepository;
use App\Repositories\SubdistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
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
            $user = $this->docterRepository->getDocterById($sessionUser->id);
        }
        return view('pages.user-profile', [
            "user" => $user,
            "subdistricts" => $this->subdistrictRepository->all()
        ]);
    }
    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]);

        return back()->with('succes', 'Profile succesfully updated');
    }
}
