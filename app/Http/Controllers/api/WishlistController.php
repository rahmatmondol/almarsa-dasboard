<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Wix\WixStore;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = auth()->user()->wishlist()->with('items')->first();
        if (!$wishlist) {
            return response()->json(['success' => false, 'message' => 'Your wishlist is empty'], 404);
        }
        $data = [
            'success' => true,
            'message' => 'Wishlist retrieved successfully',
            'product' => $wishlist,
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wixStore = new WixStore(null, null, null, $request->product_id);
        $product = $wixStore->getWixProduct();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'invalid product'], 404);
        }

        // Check if have a wishlist
        $wishlist = auth()->user()->wishlist;

        if (!$wishlist) {
            $wishlist = auth()->user()->wishlist()->create([
                'sub_total' => 0,
                'total' => 0,
            ]);
        }

        // Check if product already in wishlist
        $wishlistItem = $wishlist->items()->where('product_id', $product['id'])->first();

        if ($wishlistItem) {
            $wishlistItem->quantity += $request->quantity;
            $wishlistItem->price = $product['price']['price'];
            $wishlistItem->discount = ($product['price']['price'] - $product['price']['discountedPrice']) * $request->quantity;
            $wishlistItem->sub_total += $product['price']['discountedPrice'] * $request->quantity;
            $wishlistItem->save();

            $wishlist->sub_total = $wishlist->items->sum('sub_total');
            $wishlist->discount = $wishlist->items->sum('discount');
            $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
            $wishlist->count = $wishlist->items->sum('quantity');
            $wishlist->save();
        } else {
            $wishlistItem = $wishlist->items()->create([
                'name' => $product['name'],
                'product_id' => $product['id'],
                'image' => $product['media']['mainMedia']['thumbnail']['url'],
                'quantity' => $request->quantity,
                'price' => $product['price']['price'],
                'discount' => $product['price']['price'] - $product['price']['discountedPrice'],
                'sub_total' => $product['price']['discountedPrice'] * $request->quantity,
            ]);

            // update wishlist total
            $wishlist->sub_total = $wishlist->items->sum('sub_total');
            $wishlist->discount = $wishlist->items->sum('discount');
            $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
            $wishlist->count = $wishlist->items->sum('quantity');
            $wishlist->save();
        }

        if (!$wishlistItem) {
            return response()->json(['success' => false, 'message' => 'failed to add to wishlist'], 404);
        }

        // return response with wishlist and wishlist items
        $data = [
            'success' => true,
            'message' => 'Product added to wishlist successfully',
            'product' => $wishlist,
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $wixStore = new WixStore(null, null, null, $request->product_id);
        $product = $wixStore->getWixProduct();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'invalid product'], 404);
        }

        $wishlistItem = auth()->user()->wishlist->items()->where('product_id', $product_id)->first();
        if ($wishlistItem) {
            $wishlistItem->quantity = $request->quantity;
            $wishlistItem->price = $product['price']['price'];
            $wishlistItem->discount = ($product['price']['price'] - $product['price']['discountedPrice']) * $request->quantity;
            $wishlistItem->sub_total = $product['price']['discountedPrice'] * $request->quantity;
            $wishlistItem->save();

            // update wishlist total
            $wishlist = auth()->user()->wishlist;
            $wishlist->sub_total = $wishlist->items->sum('sub_total');
            $wishlist->discount = $wishlist->items->sum('discount');
            $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
            $wishlist->count = $wishlist->items->sum('quantity');
            $wishlist->save();
        } else {
            return response()->json(['success' => false, 'message' => 'wishlist item not found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'wishlist updated successfully',
            'wishlist' => $wishlist
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist, $id)
    {
        $wishlist = auth()->user()->wishlist->items()->find($id);
        if (!$wishlist) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $wishlist->delete();

        // update wishlist total
        $wishlist = auth()->user()->wishlist;
        $wishlist->sub_total = $wishlist->items->sum('sub_total');
        $wishlist->discount = $wishlist->items->sum('discount');
        $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
        $wishlist->count = $wishlist->items->sum('quantity');
        $wishlist->save();

        // delete wishlist item

        return response()->json([
            'success' => true,
            'message' => 'wishlist deleted successfully',
            'wishlist' => $wishlist
        ], 200);
    }


    // add wishlist item to cart
    public function addToCart(Request $request)
    {
        $product_id = $request->product_id;
        $wishlistItem = auth()->user()->wishlist->items()->where('product_id', $product_id)->first();

        try {
            if ($wishlistItem) {
                $cart = auth()->user()->cart;
                if ($cart) {
                    // add wishlist item to cart
                    $cart->items()->create($wishlistItem->toArray());

                    //delete wishlist item
                    $wishlistItem->delete();

                    // update wishlist total
                    $wishlist = auth()->user()->wishlist;
                    $wishlist->sub_total = $wishlist->items->sum('sub_total');
                    $wishlist->discount = $wishlist->items->sum('discount');
                    $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
                    $wishlist->count = $wishlist->items->sum('quantity');
                    $wishlist->save();
                } else {
                    $cart = auth()->user()->cart()->create([
                        'sub_total' => 0,
                        'total' => 0,
                    ]);

                    // add wishlist item to cart
                    $cart->items()->create($wishlistItem->toArray());
                    $wishlistItem->delete();

                    // update wishlist total
                    $wishlist = auth()->user()->wishlist;
                    $wishlist->sub_total = $wishlist->items->sum('sub_total');
                    $wishlist->discount = $wishlist->items->sum('discount');
                    $wishlist->grand_total = $wishlist->items->sum('sub_total') - $wishlist->items->sum('discount');
                    $wishlist->count = $wishlist->items->sum('quantity');
                    $wishlist->save();
                }

                $cart->sub_total = $cart->items->sum('sub_total');
                $cart->discount = $cart->items->sum('discount');
                $cart->grand_total = $cart->sub_total - $cart->discount;
                $cart->count = $cart->items->sum('quantity');
                $cart->save();

                return response()->json([
                    'success' => true,
                    'message' => 'added to cart successfully',
                    'cart' => $cart
                ], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'wishlist item not found'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'failed to add to cart', 'error' => $th->getMessage()], 404);
        }
    }
}
