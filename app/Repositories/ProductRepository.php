<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        $products = Product::with('category')
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(10);
        return $products;
    }
    public function create($created_by, $data)
    {
        try {
            $data['created_by'] = $created_by;
            return Product::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getPopularProducts()
    {
        $product = Product::with('category')
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->orderByRaw('average_rating DESC')
            ->get();

        return $product;
    }
    public function getOne($id)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->first();
        return $product;
    }
    public function searchProduct($q)
    {
        $products = Product::with('category')
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->orderByRaw('average_rating DESC')
            ->where('name', 'like', '%' . $q . '%')
            ->get();

        return $products;
    }
    public function getByCategoryId($category_id)
    {
        $products = Product::with('category')
            ->selectRaw('products.*, ROUND(AVG(reviews.rating), 2) as average_rating')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->orderByRaw('average_rating DESC')
            ->where('category_id', $category_id)
            ->get();
        return $products;
    }
}