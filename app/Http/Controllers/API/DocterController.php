<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\DocterResource;
use App\Models\Docter;
use App\Repositories\DocterRepository;
use Illuminate\Http\Request;
use DB;

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
    public function filterDocter(Request $request)
    {
        $subdistrict_id = $request->input('subdistrict_id');
        $category_id = $request->input('category_id');
        $user_id = $request->user()->id; 

        $docters = Docter::with(['images', 'category', 'subdistrict'])
        ->orWhere(function ($query) use ($category_id, $subdistrict_id) {
            if ($category_id && !$subdistrict_id) {
                $query->where('category_docter_id', $category_id);
            } elseif (!$category_id && $subdistrict_id) {
                $query->where('subdistrict_id', $subdistrict_id);
            }elseif($category_id && $subdistrict_id) {
                $query->where('subdistrict_id', $subdistrict_id)
                        ->where('category_docter_id', $category_id);
            }
        })
        ->leftJoin('saved_docters', function ($join) use ($user_id) {
            $join->on('docters.id', '=', 'saved_docters.docter_id')
                ->where('saved_docters.created_by', $user_id);
        })
        ->select('docters.*', DB::raw("IF(saved_docters.created_by = '$user_id', 1, 0) as save_by_you"))
        ->get();
    
    return $this->requestSuccessData(DocterResource::collection($docters));  
    }
}

