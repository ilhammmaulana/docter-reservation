<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PhotoRequest;
use App\Http\Resources\API\BannerResource;
use App\Models\PromoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoBannerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try { 
            return $this->requestSuccessData(BannerResource::collection(PromoBanner::get()));
        } catch (\Throwable $th) {
            throw $this->badRequest("", $th);
        }
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
     * @param  \Illuminate\Http\Request  $photoRequest
     * @return \Illuminate\Http\Response
     */
    public function store(PhotoRequest $photoRequest)
    {
        try {
            $photo = $photoRequest->file('photo');
            $path = 'public/' . Storage::disk('public')->put('images/banner', $photo);
            PromoBanner::create([
                "photo" => $path
            ]);
            return $this->requestSuccess();
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
    public function update(PhotoRequest $photoRequest, $id)
    {
        try {
            $banner = PromoBanner::findOrFail($id);
            $input = [];
            if ($photoRequest->hasFile('photo')) {
                if ($banner->photo) {
                    Storage::delete($banner->photo);
                }
                $imagePath = $photoRequest->file('photo')->store('images/banner', 'public');
                $input['photo'] = 'public/' . $imagePath;
            }            
            $banner->update($input);
            $banner['photo'] = url($input['photo']);
            return $this->requestSuccessData($banner);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound("Banner not found!", $th);
        } catch (\Throwable $th) {
            throw $th;
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
        try {
            $banner = PromoBanner::findOrFail($id);
            if ($banner->photo) {
                Storage::delete($banner->photo);
            }
            return $this->requestSuccess();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->requestNotFound("Banner not found!", $th);
        } catch (\Throwable $th) {
            throw $th;
        }    }
}
