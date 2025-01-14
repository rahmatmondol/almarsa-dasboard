<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function index(Request $request): Response
    {
        $carts = Cart::all();

        return new CartCollection($carts);
    }

    public function store(CartStoreRequest $request): Response
    {
        $cart = Cart::create($request->validated());

        return new CartResource($cart);
    }

    public function show(Request $request, Cart $cart): Response
    {
        return new CartResource($cart);
    }

    public function update(CartUpdateRequest $request, Cart $cart): Response
    {
        $cart->update($request->validated());

        return new CartResource($cart);
    }

    public function destroy(Request $request, Cart $cart): Response
    {
        $cart->delete();

        return response()->noContent();
    }
}
