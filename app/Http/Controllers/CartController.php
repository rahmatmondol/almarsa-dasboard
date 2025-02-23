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
    // get cart
    public function index(Request $request)
    {
        // return response with cart and cart items
        $cart = auth()->user()->cart()->with('items')->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty'], 404);
        }

        $data = [
            'success' => true,
            'message' => 'Cart retrieved successfully',
            'product' => $cart,
        ];

        return response()->json($data, 200);
    }

    // add product to cart
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
            $cart = auth()->user()->cart()->create([
                'sub_total' => 0,
                'total' => 0,
            ]);
        }

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product['id'])->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $product['price']['price'];
            $cartItem->discount = ($product['price']['price'] - $product['price']['discountedPrice']) * $request->quantity;
            $cartItem->sub_total += $product['price']['discountedPrice'] * $request->quantity;
            $cartItem->save();

            $cart->sub_total = $cart->items->sum('sub_total');
            $cart->discount = $cart->items->sum('discount');
            $cart->grand_total = $cart->items->sum('sub_total') - $cart->items->sum('discount');
            $cart->count = $cart->items->sum('quantity');
            $cart->save();
        } else {
            $cartItem = $cart->items()->create([
                'name' => $product['name'],
                'product_id' => $product['id'],
                'image' => $product['media']['mainMedia']['image']['url'],
                'quantity' => $request->quantity,
                'price' => $product['price']['price'],
                'discount' => $product['price']['price'] - $product['price']['discountedPrice'],
                'sub_total' => $product['price']['discountedPrice'] * $request->quantity,
                'cart_id' => $cart->id
            ]);

            // update cart total
            $cart->sub_total = $cart->items->sum('sub_total');
            $cart->discount = $cart->items->sum('discount');
            $cart->grand_total = $cart->items->sum('sub_total') - $cart->items->sum('discount');
            $cart->count = $cart->items->sum('quantity');
            $cart->save();
        }

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'failed to add to cart'], 404);
        }


        // return response with cart and cart items
        $cart = Cart::with('items')->find($cart->id);

        $data = [
            'success' => true,
            'message' => 'Product added to cart successfully',
            'product' => $cart,
        ];

        return response()->json($data, 200);
    }

    // show cart
    public function show(Request $request, Cart $cart)
    {
        return new CartResource($cart);
    }

    // update cart
    public function update(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $wixStore = new WixStore(null, null, null, $request->product_id);
        $product = $wixStore->getWixProduct();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'invalid product'], 404);
        }

        $cartItem = auth()->user()->cart->items()->where('product_id', $product_id)->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->price = $product['price']['price'];
            $cartItem->discount = ($product['price']['price'] - $product['price']['discountedPrice']) * $request->quantity;
            $cartItem->sub_total = $product['price']['discountedPrice'] * $request->quantity;
            $cartItem->save();

            // update cart total
            $cart = auth()->user()->cart;
            $cart->sub_total = $cart->items->sum('sub_total');
            $cart->discount = $cart->items->sum('discount');
            $cart->grand_total = $cart->items->sum('sub_total') - $cart->items->sum('discount');
            $cart->count = $cart->items->sum('quantity');
            $cart->save();
        } else {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $CartItem = auth()->user()->cart->items()->find($id);
        if (!$CartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $CartItem->delete();

        // update cart total
        $cart = auth()->user()->cart;
        $cart->sub_total = $cart->items->sum('sub_total');
        $cart->discount = $cart->items->sum('discount');
        $cart->grand_total = $cart->items->sum('sub_total') - $cart->items->sum('discount');
        $cart->count = $cart->items->sum('quantity');
        $cart->save();

        // delete cart item

        return response()->json([
            'success' => true,
            'message' => 'Cart deleted successfully',
            'cart' => $cart
        ], 200);
    }
}
