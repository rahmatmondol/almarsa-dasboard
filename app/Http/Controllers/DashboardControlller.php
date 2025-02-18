<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardControlller extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $orderGrowth = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $totalCustomers = User::count();
        $customerGrowth = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $totalCategories = Category::count();
        $recentOrders = Order::latest()->take(5)->get();
        $recentCustomers = User::latest()->take(5)->withCount('orders')->get();
        return view('dashboard', compact('totalOrders', 'orderGrowth', 'totalCustomers', 'customerGrowth', 'totalCategories', 'recentOrders', 'recentCustomers'));
    }
}
