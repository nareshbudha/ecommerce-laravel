<?php
namespace App\Http\Controllers\DashBoard;

use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems')->orderBy('id', 'desc')->take(5)->get();
        $product = Product::all();
        $pending_orders_amount = Order::where('status', 'pending')->sum('total');
        $total_orders = Order::count();
        $total_amount = Order::sum('total');
        $pending_orders = Order::where('status', 'pending')->count();
        $delivered_orders = Order::where('status', 'delivered')->count();
        $delivered_orders_amount = Order::where('status', 'delivered')->sum('total');
        $canceled_orders = Order::where('status', 'canceled')->count();
        $canceled_orders_amount = Order::where('status', 'canceled')->sum('total');
        $revenue = Order::sum('total'); 
        $revenue_trend = $this->calculateTrend('revenue'); 
        $order_value = Order::sum('subtotal'); 
        $order_trend = $this->calculateTrend('order'); 
        return view('dashboard.pages.index.index', compact(
            'orders',
            'pending_orders_amount',
            'total_orders',
            'total_amount',
            'pending_orders',
            'delivered_orders',
            'delivered_orders_amount',
            'canceled_orders',
            'canceled_orders_amount',
            'revenue',
            'revenue_trend',
            'order_value',
            'order_trend',
            'product'  
        ));
    }

    private function calculateTrend($type)
    {
        return rand(-10, 10); 
    }
}
