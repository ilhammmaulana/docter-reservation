<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\CreateUserRequest;
use App\Models\User;
use App\Repositories\SubdistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    private $userRepository, $subdistrictRepository;

    function __construct(UserRepository $userRepository, SubdistrictRepository $subdistrictRepository)
    {
        $this->userRepository = $userRepository;
        $this->subdistrictRepository = $subdistrictRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.user-management", [
            "users" => $this->userRepository->getUser('user', auth()->id()),
            "subdistricts" => $this->subdistrictRepository->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        try {
            $input = $createUserRequest->only("name", "email", "password", "phone", "subdistrict_id");
            $image = $createUserRequest->file('photo');
            $path = 'public/' . Storage::disk('public')->put('images/users', $image);
            $input['photo'] = $path;
            $this->userRepository->create($input);
            return redirect()->route('user-managements')->with('success', 'Success create user');
        } catch (\Throwable $th) {
            return redirect()->route('user-managements.index')->with('error', 'Failed!, Email allready exist!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->only("name", "email", "phone", "subdistrict_id");

            $user = User::findOrFail($id);

            if ($request->has('password')) {
                $user['password'] = bcrypt($request->input('password'));
            }
            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::delete($user->photo);
                }

                $imagePath = $request->file('photo')->store('images/users', 'public');
                $user['photo'] = 'public/' . $imagePath;
            }
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->save();
            return redirect()->route('user-managements')->with('success', 'User update successfully');
        } catch (\Throwable $th) {
            return redirect()->route('user-managements.index')->with('error', 'Failed! Email already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
