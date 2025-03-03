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
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::withCount('items')->latest();

        if ($status === 'completed') {
            $orders->where('status', 'Completed');
        } elseif ($status === 'cancelled') {
            $orders->where('status', 'cancelled');
        } elseif ($status === 'pending') {
            $orders->where('status', 'pending');
        } elseif ($status === 'Processing') {
            $orders->where('status', 'Processing');
        } elseif ($status === 'Failed') {
            $orders->where('status', 'Failed');
        } elseif ($status === 'Refunded') {
            $orders->where('status', 'Refunded');
        } elseif ($status === 'Payment_pending') {
            $orders->where('status', 'Payment_pending');
        }

        $orders = $orders->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('items', 'user','address');
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
                'order_id' => $order->id,
                'status' => $order->status,
                'type' => 'order',
            ],
            'title' => 'Order updated',
        ]);

        return redirect()->back();
    }

    // make order dtails to pdf
    public function pdf(Order $order)
    {
        $order->load('items', 'user', 'address');

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
