<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\DocterResource;
use App\Repositories\DocterRepository;
use Illuminate\Http\Request;

class DocterController extends ApiController
{
    private $docterRepository;
    /**
     * Class constructor.
     */
    public function __construct(DocterRepository $docterRepository)
    {
        $this->docterRepository = $docterRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($q = $request->query('q')) {
            return  $this->requestSuccessData(DocterResource::collection($this->docterRepository->searchDocter($q, $this->guard()->id())));
        }
        return $this->requestSuccessData(DocterResource::collection($this->docterRepository->getDocters($this->guard()->id())));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->requestSuccessData(new DocterResource($this->docterRepository->getDocterById($id, $this->guard()->id())));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Docter not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
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
        //
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

    public function filterBySubdistrict($id)
    {
        try {
            return $this->requestSuccessData(DocterResource::collection($this->docterRepository->getDocterBySubdistrictId($id, $this->guard()->id())));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function historyDocter()
    {
         return $this->requestSuccessData($this->docterRepository->getDocterHistory($this->guard()->id()));
    }
}

