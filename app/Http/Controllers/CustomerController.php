<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::role('customer')->with('orders')->latest()->get();
        $total_spent = $users->map(function ($user) {
            return $user->orders->sum('grand_total');
        });

        $users->transform(function ($user, $key) use ($total_spent) {
            $user->total_spent = $total_spent[$key];
            return $user;
        });

        return view('customer.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = User::where('id', $id)->with(['orders', 'cart', 'cart.items', 'wishlist', 'wishlist.items'])->first();
        return view('customer.show', compact('customer'));
    }

    // edit
    public function edit(User $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully');
    }
}
