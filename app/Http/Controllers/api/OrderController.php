<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\FirebaseDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public $firebaseDatabase;
    public function __construct(FirebaseDatabase $firebaseDatabase)
    {
        $this->firebaseDatabase = $firebaseDatabase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oredrs = auth()->user()->orders()->with('items', 'address')->latest()->get();
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
            'address_id' => 'required|string',
        ]);

        // create order
        DB::beginTransaction();
        try {
            $order = auth()->user()->orders()->create([
                'address_id' => $request->address_id
            ]);

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

            // firebase notification
            $this->firebaseDatabase->create('/notifications/admin', [
                'created_at' => now(),
                'read_at' => false,
                'data' => [
                    'url' => 'order/show/' . $order->id,
                    'avatar' => auth()->user()->image,
                    'name' => auth()->user()->name,
                    'message' => auth()->user()->name . ' has placed a order',
                ],
                'title' => 'New order placed',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order created successfully', 'data' => $order], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong', 'error' => $th->getMessage()], 500);
        }
    }


    // order to cart
    public function orderAgain(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'address_id' => 'required|string',
        ]);

        $order = auth()->user()->orders()->with('items')->find($request->order_id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order = $order->makeHidden('created_at', 'updated_at', 'deleted_at', 'user_id', 'status', 'id');
        $order['address_id'] = $request->address_id;

        // create order
        DB::beginTransaction();
        try {
            $newOrder = auth()->user()->orders()->create($order->toArray());

            if (!$newOrder) {
                return response()->json(['success' => false, 'message' => 'cannot create order please try again'], 500);
            }


            foreach ($order->items as $item) {
                $newOrder->items()->create($item->toArray());
            }

            // firebase notification
            $this->firebaseDatabase->create('/notifications/admin', [
                'created_at' => now(),
                'read_at' => false,
                'data' => [
                    'url' => 'order/show/' . $newOrder->id,
                    'avatar' => auth()->user()->image,
                    'name' => auth()->user()->name,
                    'message' => auth()->user()->name . ' has made order again',
                ],
                'title' => 'New order placed',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order created successfully', 'data' => $newOrder->load('items')], 201);
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
        $order = auth()->user()->orders()->with('items', 'address')->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Order retrieved successfully', 'data' => $order], 200);
    }
}
