<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Default to weekly sales data
        $range = 'today';
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $groupFormat = 'DATE(created_at)'; // Group by date for weekly sales
    
        // Fetch sales data grouped by date
        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw("$groupFormat as period, SUM(total_price) as total_sales")
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->get();
    
        // Format labels for the frontend chart
        $labels = $salesData->pluck('period')->map(function ($value) {
            return Carbon::parse($value)->format('D, d M'); // Example: Mon, 04 Mar
        })->toArray();
    
        // Calculate total sales directly from the summed salesData
        $totalSales =Order::where('status', 'completed')->sum('total_price'); 
    
        // Calculate total completed orders
        $totalOrders = Order::where('status', 'completed')->count();
    
        // Today Sale
        $dailySales = Order::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                ->where('status', 'completed')
                ->sum('total_price');
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

        return view('admin.sales_report.index', compact('salesData', 'totalSales', 'totalOrders', 'labels', 'range','dailySales','weeklySales','monthlySales','yearlySales'));
    }



public function getSalesData(Request $request)
{
    $range = $request->get('range', 'week'); // Default to 'daily'

    if ($range == 'daily') {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $dateFormat = '%Y-%m-%d';
    }elseif ($range == 'week') {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $dateFormat = '%Y-%m-%d';
    } elseif ($range == 'month') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dateFormat = '%Y-%m-%d';
    } elseif ($range == 'year') {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
        $dateFormat = '%Y-%m';
    } else {
        return response()->json([
            'error' => 'Invalid range parameter'
        ], 400); // Return 400 error if range is invalid
    }

    // Fetch sales data
    $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw("DATE_FORMAT(created_at, '{$dateFormat}') as date, SUM(total_price) as total_sales")
        ->where('status', 'completed')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json([
        'labels' => $salesData->pluck('date')->toArray(),
        'sales' => $salesData->pluck('total_sales')->toArray()
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
