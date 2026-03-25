<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $today = Carbon::today();

        // hitung pendapatan hari ini (hanya dari pesanan yang sudha pain)
        $todayRevenue = Order::whereDate('created_at', $today)
        ->where('status', 'paid')->sum('total_price');

        // hitung total transaksi hari ini (semua status)
        $totalOrders = Order::whereDate('created_at', $today)
        ->count();

        // peringatan stok menipis
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return response()->json([
            'message' => 'Laporan hari ini berhasil ditarik',
            'data' => [
                'today_revenue' => $todayRevenue,
                'total_orders' => $totalOrders,
                'low_stock_alerts' => $lowStockProducts
            ]
        ],200);
    }
}
