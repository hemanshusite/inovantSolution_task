<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['totalProducts'] = Product::count();
        $data['totalOrders'] = Order::count();
        $data['totalUsers'] = User::count();
        $data['totalRevenue'] = Order::sum('total_amount');
        $data['recentProducts'] = Product::latest()->take(5)->get();

        return view('backend.dashboard.index', $data);
    }
}
