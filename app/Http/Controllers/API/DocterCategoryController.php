<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\API\CategoryResource;
use App\Http\Resources\API\DocterResource;
use App\Models\CategoryDocter;
use App\Repositories\DocterRepository;
use Illuminate\Http\Request;

class DocterCategoryController extends ApiController
{
    private $docterRepository;
    public function __construct(DocterRepository $docterRepository)
    {
        $this->docterRepository = $docterRepository;
    }
    public function index()
    {
        return $this->requestSuccessData(CategoryResource::collection(CategoryDocter::all()));
    }
    public function show($id)
    {

        try {
            return $this->requestSuccessData(DocterResource::collection($this->docterRepository->getDocterByCategoryId($id, $this->guard()->id())));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound('Category not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
