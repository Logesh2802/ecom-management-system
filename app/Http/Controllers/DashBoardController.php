<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::where('status', 'completed')->count(); 
        $products = Product::count(); 
        $categories = Category::count(); 
        $totalSales =Order::where('status', 'completed')->sum('total_price'); 
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total_sales')
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        // Weekly Sale
        $weeklySales = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->where('status','completed')
                                ->sum('total_price');

        // Monthly Sale
        $monthlySales = Order::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                                ->where('status','completed')
                                ->sum('total_price');
        
        // Yearly Sale
        $yearlySales = Order::whereYear('created_at', Carbon::now()->year)
                                ->where('status','completed')
                                ->sum('total_price');
        return view('admin.dashboard.index', compact('totalOrders', 'products', 'categories', 'totalSales','salesData','monthlySales','weeklySales','yearlySales'));
    }
}
