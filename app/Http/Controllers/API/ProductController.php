<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ProductAndReviewResource;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\This;

class ProductController extends ApiController
{
    private $productRepository;
    /**
     * Class constructor.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        if ($q) {
            return $this->requestSuccessData(ProductResource::collection($this->productRepository->searchProduct($q)));
        }
        return $this->requestSuccessData(ProductResource::collection($this->productRepository->getPopularProducts()));
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
        return $this->requestSuccessData(new ProductAndReviewResource($this->productRepository->getOne($id)));
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
        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                Storage::delete($product->image);
            }

            // Delete the product record from the database
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        } catch (\Throwable $th) {
            // Handle exceptions or errors here, for example, you can return a 404 view if the product is not found
            return view('errors.404');
        }
    }
    public function getByCategory($id)
    {
        return $this->requestSuccessData(ProductResource::collection($this->productRepository->getByCategoryId($id)));
    }
}
