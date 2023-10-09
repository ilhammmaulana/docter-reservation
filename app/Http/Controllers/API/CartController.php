<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CartIdRequest;
use App\Http\Requests\API\UpdateCartRequest;
use App\Http\Resources\API\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CartController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $carts = Cart::with('product')->where('created_by', $this->guard()->id())->where('order_id', '=', null)->latest()->get();
            return $this->requestSuccessData(CartResource::collection($carts));
        } catch (\Throwable $th) {
            //throw $th;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only('product_id');
            $product = Product::findOrFail($input['product_id']);

            $user_id = $this->guard()->id();
            $existingCart = Cart::where('product_id', $input['product_id'])
                ->where('created_by', $user_id)
                ->whereNull('order_id')
                ->first();

            if ($existingCart) {
                $existingCart->qty += 1;
                $existingCart->save();
            } else {
                $input['created_by'] = $user_id;
                $input['qty'] = 1;
                Cart::create($input);
            }

            return $this->requestSuccess();
        } catch (ModelNotFoundException $th) {
            return $this->requestNotFound('Product not found!');
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
    public function update(UpdateCartRequest $updateCartRequest, $id)
    {
        try {
            $cart = Cart::with('product')->where('id', '=', $id)->where('created_by', '=', $this->guard()->id())->firstOrFail();
            $input = $updateCartRequest->only('qty');
            $newQty = $input['qty'];

            if ($newQty <= $cart->product->stock) {
                $cart->update($input);
                return $this->requestSuccess();
            } else {
                return $this->badRequest('not_available_stocks', 'Failed! Quantity exceeds available stock');
            }
        } catch (ModelNotFoundException $th) {
            return $this->requestNotFound('Cart not found!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function decrement(CartIdRequest $cartIdRequest)
    {
        try {
            $cartId = $cartIdRequest->input('id_cart');
            $user_id = $this->guard()->id();

            $cart = Cart::where('id', $cartId)
                ->where('created_by', $user_id)
                ->whereNull('order_id')
                ->first();

            if ($cart) {
                if ($cart->qty > 1) {
                    $cart->qty -= 1;
                    $cart->save();
                    return $this->requestSuccess();
                } else {
                    $cart->delete();
                    return $this->requestSuccess();
                }
            } else {
                return $this->requestNotFound('Cart not found !');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function increment(CartIdRequest $cartIdRequest)
    {
        try {
            $cartId = $cartIdRequest->input('id_cart');

            $cart = Cart::with('product')->where('id', $cartId)
                ->where('created_by', $this->guard()->id())
                ->whereNull('order_id')
                ->first();

            if ($cart) {
                // Jumlah saat ini dalam Cart
                $currentQty = $cart->qty;

                // Jumlah maksimum stok produk
                $maxStock = $cart->product->stock;

                if ($currentQty < $maxStock) {
                    // Jika qty dalam Cart belum mencapai stok maksimum, tambahkan qty
                    $cart->qty += 1;
                    $cart->save();
                    return $this->requestSuccess();
                } else {
                    return $this->badRequest('not_available_stocks', 'Failed! Quantity exceeds available stock');
                }
            } else {
                return $this->requestNotFound('Cart not found!');
            }
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
        $deleted = Cart::where('id', $id)
            ->where('created_by', $this->guard()->id())
            ->whereNull('order_id')
            ->delete();
        if ($deleted) {
            return $this->requestSuccess('Success! Deleted cart');
        } else {
            return $this->requestNotFound('Cart not found!');
        }
    }
}
