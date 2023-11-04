<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DocterIdRequest;
use App\Http\Resources\API\DocterResource;
use App\Repositories\DocterRepository;
use App\Services\DocterService;
use Illuminate\Http\Request;

class SavedDocterController extends ApiController
{
    private $docterRepository, $docterService;
    /**
     * Class constructor.
     */
    public function __construct(DocterRepository $docterRepository, DocterService $docterService)
    {
        $this->docterRepository = $docterRepository;
        $this->docterService = $docterService;
    }

    /**
     * Display a listing of the resource.
     * All Docter when docter saved by user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->requestSuccessData(DocterResource::collection($this->docterRepository->getSavedDocter($this->guard()->id())));
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
    public function store(DocterIdRequest $docterIdRequest)
    {
        try {
            return $this->requestSuccessData($this->docterService->toogleSaveDocter($this->guard()->id(), $docterIdRequest->get('docter_id')));
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
}
