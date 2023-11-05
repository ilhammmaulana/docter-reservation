<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateCartRequest;
use App\Http\Requests\WEB\CreateDocterRequest;
use App\Http\Requests\WEB\UpdateDocterRequest;
use App\Models\CategoryDocter;
use App\Models\Docter;
use App\Repositories\SubdistrictRepository;
use App\Repositories\DocterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocterController extends Controller
{
    private $docterRepository, $subdistrictRepository;

    function __construct(DocterRepository $docterRepository, SubdistrictRepository $subdistrictRepository)
    {
        $this->docterRepository = $docterRepository;
        $this->subdistrictRepository = $subdistrictRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.docters", [
            "subdistricts" => $this->subdistrictRepository->all(),
            "docters" => $this->docterRepository->all(true, 10),
            "categories" => CategoryDocter::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDocterRequest $createDocterRequest)
    {
        try {
            $input = $createDocterRequest->only('name', 'email', 'phone', 'password', 'subdistrict_id', 'category_docter_id', 'address', 'description');
            $photo = $createDocterRequest->file('photo');
            $path = Storage::disk('public')->put('images/users', $photo);
            $input['password'] = bcrypt($input['password']);
            $input['photo'] = 'public/' . $path;
            Docter::create($input);
            return redirect()->route('docters.index')->with('success', 'Success create docter!');
        } catch (\Throwable $th) {
            throw $th;
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
        return view('pages.docters-edit', [
            "docter" => $this->docterRepository->getDocterById($id, getDataUser()->id),
            "categories" => CategoryDocter::all(),
            "subdistricts" => $this->subdistrictRepository->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocterRequest $updateDocterRequest, $id)
    {
        $photo = $updateDocterRequest->file('photo');
        $user = $this->docterRepository->getDocterById($id, getDataUser()->id);
        $input = $updateDocterRequest->only('name', 'email', 'phone', 'subdistrict_id', 'description', 'category_docter_id', 'address');
        if ($updateDocterRequest->has('password')) {
            $input['password'] = bcrypt($updateDocterRequest->input('password'));
        }
        if ($photo) {
            $pathDelete = $user->photo;
            if ($pathDelete !== null) {
                Storage::delete($pathDelete);
            }
            $path = Storage::disk('public')->put('images/users', $photo);
            $user->photo = 'public/' . $path;
        }
        $user->update($input);
        return back()->with('success', 'Profile successfully updated');
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
    /**
     * For docter update opration
     */
    public function updateOpration()
    {
        try {
            $docter = Docter::findOrFail(getDataUser()->id);
            if ($docter->status_opration == true) {
                $docter->status_opration = false;
            } else {
                $docter->status_opration = true;
            }
            $docter->save();
            return redirect()->route('profile')->with('success', 'Successfully update your status opration');
        } catch (ModelNotFoundException $th) {
            return redirect()->route('docters.index')->with('error', 'Forbidden!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
