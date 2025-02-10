<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Wix\WixStore;

class CartController extends Controller
{
    public function index(Request $request): Response
    {
        $carts = Cart::all();

        return new CartCollection($carts);
    }

    public function store(CartStoreRequest $request)
    {

        $wixStore = new WixStore(null, null, null, $request->product_id);
        $product = $wixStore->getWixProduct();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'invalid product'], 404);
        }

        // Check if have a cart
        $cart = auth()->user()->cart;

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->user()->id
            ]);
        }

        // Check if product already in cart
        $cartItem = CartItem::where('product_id', $product['id'])->where('user_id', auth()->user()->id)->first();
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->amount += $product['price']['discountedPrice'] * $request->quantity;
            $cartItem->save();

            // update cart total
            $cart->total += $product['price']['discountedPrice'] * $request->quantity;
            $cart->sub_total += $product['price']['discountedPrice'] * $request->quantity;
            $cart->count += $request->quantity;
            $cart->save();
        } else {
            $cartItem = CartItem::create([
                'product_id' => $product['id'],
                'quantity' => $request->quantity,
                'amount' => $product['price']['discountedPrice'] * $request->quantity,
                'user_id' => auth()->user()->id,
                'cart_id' => $cart->id
            ]);

            // update cart total
            $cart->total += $product['price']['discountedPrice'] * $request->quantity;
            $cart->sub_total += $product['price']['discountedPrice'] * $request->quantity;
            $cart->count += $request->quantity;
            $cart->save();
        }

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'failed to add to cart'], 404);
        }


        // return response with cart and cart items
        $cart = Cart::with('cartItems')->find($cart->id);

        $data = [
            'success' => true,
            'message' => 'Products retrieved successfully',
            'product' => $cart,
        ];

        return response()->json($data, 200);
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
