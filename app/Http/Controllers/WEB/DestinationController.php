<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateDestinationReview;
use App\Http\Requests\WEB\CreateDestinationRequest;
use App\Http\Requests\WEB\UpdateDestinationRequest;
use App\Models\Destination;
use App\Repositories\CategoryDestinationRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\PlacesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    private $destinationRepository, $categoryDestinationRepository, $placesRepository;
    /**
     * Class constructor.
     */
    public function __construct(DestinationRepository $destinationRepository, CategoryDestinationRepository $categoryDestinationRepository, PlacesRepository $placesRepository)
    {
        $this->destinationRepository = $destinationRepository;
        $this->categoryDestinationRepository = $categoryDestinationRepository;
        $this->placesRepository = $placesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinataions = $this->destinationRepository->getAllDestination(true);
        $categories = $this->categoryDestinationRepository->getDestinationCategories();
        $cities = $this->placesRepository->getCities();
        $provinces = $this->placesRepository->getProvinces();
        return view('pages.destinations', [
            "destinations" =>  $destinataions,
            "category_destinations" => $categories,
            "cities" =>  $cities,
            "provinces" =>  $provinces,
            "page" => "destinations"
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
    public function store(CreateDestinationRequest $createDestinationRequest)
    {
        try {
            $input = $createDestinationRequest->only('name', 'address', 'price', 'category_id', 'city_id', 'province_id', 'longitude', 'latitude', 'description');
            $image = $createDestinationRequest->file('image');
            $path = Storage::disk('public')->put('images/users', $image);
            $input['image'] = 'public/' . $path;
            $this->destinationRepository->createDestination($input);
            return redirect()->to('destinations')->with('success', "Success Create destination with name " . $input['name']);
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
    public function update(UpdateDestinationRequest $updateDestinationRequest, $id)
    {
        try {
            $input = $updateDestinationRequest->only('name', 'address', 'price', 'category_id', 'city_id', 'province_id', 'longitude', 'latitude', 'description');

            // Update the destination
            $destination = Destination::findOrFail($id);
            $destination->update($input);

            // Handle optional image update
            if ($updateDestinationRequest->hasFile('image')) {
                if ($destination->image) {
                    Storage::delete($destination->image);
                }

                // Upload and store the new image
                $imagePath = $updateDestinationRequest->file('image')->store('destination_images', 'public');
                $destination->image = 'public/' . $imagePath;
                $destination->save();
            }

            return redirect('destinations')->with('success', 'Destination updated successfully');
        } catch (ModelNotFoundException $e) {
            redirect('destinations')->with('failed', 'Maaf destinasi tidak dapat ditemukan');
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
        $this->destinationRepository->deleteDestination($id);
        return redirect('destinations')->with('success', 'Success delete destination');
    }
}
