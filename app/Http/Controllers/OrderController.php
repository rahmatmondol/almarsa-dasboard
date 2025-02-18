<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FirebaseDatabase;
use Illuminate\Http\Request;

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
        $orders = Order::withCount('items')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('items', 'user');
        $user = $order->user;
        return view('orders.show', compact('order', 'user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        // send notification to user
        $this->firebaseDatabase->create('/notifications/user_' . $order->user_id, [
            'created_at' => now(),
            'read_at' => false,
            'data' => [
                'message' => 'Your order has been updated to ' . $order->status,
            ],
            'title' => 'Order updated',
        ]);

        return redirect()->back();
    }

    // make order dtails to pdf
    public function pdf(Order $order)
    {
        $order->load('items', 'user');
       
        return view('orders.invoice', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index');
    }
}
