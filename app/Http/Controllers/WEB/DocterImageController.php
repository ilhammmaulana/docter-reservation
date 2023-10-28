<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\CreateImageDocterRequest;
use App\Models\Docter;
use App\Models\DocterImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocterImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(CreateImageDocterRequest $createImageDocterRequest)
    {
        try {
            $uploadedImages = [];
            DB::transaction(function () use ($createImageDocterRequest, $uploadedImages) {
                foreach ($createImageDocterRequest->file('images') as $imagefile) {
                    $input = [];
                    $path = $imagefile->store('images/docters', 'public');
                    $input['image'] = 'public/' . $path;
                    $input['docter_id'] = $createImageDocterRequest->get('docter_id');
                    $docterImage = DocterImage::create($input);
                    $uploadedImages[] = $docterImage;
                }
            });
            return redirect()->back()->with('success', 'Success upload photo!');
        } catch (\Throwable $th) {
            foreach ($uploadedImages as $image) {
                $image->delete();
            }
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
        $image = DocterImage::find($id);
        Storage::delete($image['image']);
        $image->delete();
        return redirect()->back()->with('success', "Success delete image!");
    }
}
