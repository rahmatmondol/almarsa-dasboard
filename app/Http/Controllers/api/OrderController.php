<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oredrs = auth()->user()->orders()->with('items')->get();
        $data = [
            'status' => 'success',
            'message' => 'Orders retrieved successfully',
            'data' => $oredrs
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get cart
        $cart = auth()->user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty'], 404);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'address2' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
        ]);

        // create order
        // DB::beginTransaction();
        try {
            $order = auth()->user()->orders()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'address2' => $request->address2,
                'city' => $request->city,
                'country' => $request->country,
                'phone' => $request->phone,
                'shipping_first_name' => $request->first_name,
                'shipping_last_name' => $request->last_name,
                'shipping_address' => $request->address,
                'shipping_address2' => $request->address2,
                'shipping_city' => $request->city,
                'shipping_country' => $request->country,
                'shipping_state' => $request->state,
                'shipping_postal_code' => $request->postal_code,
                'shipping_phone' => $request->phone
            ]);

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'cannot create order please try again'], 500);
            }


            // create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'name' => $item->name,
                    'product_id' => $item->product_id,
                    'image' => $item->image,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'quantity' => $item->quantity,
                    'sub_total' => $item->sub_total,
                    'total' => $item->total
                ]);
            }

            // delete cart
            $cart->delete();

            // update order
            $order->update([
                'sub_total' => $order->items->sum('sub_total'),
                'discount' => $order->items->sum('discount'),
                'grand_total' => $order->items->sum('sub_total') - $order->items->sum('discount'),
                'count' => $order->items->sum('quantity')
            ]);

            return  $order;

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order created successfully', 'data' => $order], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = auth()->user()->orders()->with('items')->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Order retrieved successfully', 'data' => $order], 200);
    }
}
