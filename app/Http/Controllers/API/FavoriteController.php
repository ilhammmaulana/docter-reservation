<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use App\Repositories\FavoriteRepository;
use App\Repositories\ProductRepository;
use App\Services\FavoriteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FavoriteController extends ApiController
{
    private $favoriteService, $favoriteRepository;
    /**
     * Class constructor.
     */
    public function __construct(FavoriteService $favoriteService, FavoriteRepository $favoriteRepository)
    {
        $this->favoriteService = $favoriteService;
        $this->favoriteRepository = $favoriteRepository;
    }
    /**
     * Display all history favorite products user
     */
    public function index()
    {
        return $this->requestSuccessData(ProductResource::collection($this->favoriteRepository->getProducts($this->guard()->id())));
    }

    public function store(Request $request)
    {
        try {
            $input = $request->only('product_id');
            Product::findOrFail($input['product_id']);
            $response = $this->favoriteService->toogle($this->guard()->id(), $input['product_id']);
            return $this->requestSuccessData($response);
        } catch (ModelNotFoundException $th) {
            return $this->requestNotFound('Product not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
