<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\Product;

class FavoriteRepository
{


    public function addToFavorites($id_user, $product_id)
    {
        Favorite::create([
            "created_by" => $id_user,
            "product_id" => $product_id
        ]);
    }

    public function removeFromFavorites($id_user, $product_id)
    {
        Favorite::where('created_by', $id_user)->where('product_id', $product_id)->delete();
    }
    public function isFavorite($user_id, $product_id)
    {
        $favorite = Favorite::where('created_by', $user_id)
            ->where('product_id', $product_id)
            ->first();
        return $favorite !== null;
    }
    public function getProducts($id_user)
    {
        $products = Product::with('category')
            ->join('favorites', 'products.id', '=', 'favorites.product_id')
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('favorites.created_by', $id_user) // Menambahkan kondisi WHERE
            ->groupBy('products.id')
            ->orderByRaw('average_rating DESC')
            ->get();
        return $products;
    }
}