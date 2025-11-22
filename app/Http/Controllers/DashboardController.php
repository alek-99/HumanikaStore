<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {

        // Total Produk
        $totalProduk = Product::count();

        // Total order
        $totalOrder = Order::count();

        // Order Selesai
        $orderSelesai = Order::where('status', 'confirmed')->count();

        // Order Proses
        $orderProses = Order::where('status', 'process')->count();

        // Total Admin
        $totalAdmin = User::where('role', 'admin')->count();

        // Total User Biasa
        $totalUser = User::where('role', 'user')->count();

        // Statistik Order Per Bulan
        $chartOrderPerBulan = Order::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalOrder',
            'orderSelesai',
            'orderProses',
            'totalAdmin',
            'totalUser',
            'chartOrderPerBulan'
        ));

    } else {
        $orderProses = Order::where('user_id', $user->id)
            ->where('status', 'process')
            ->count();
            $produkDibeli = Order::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->count();
            $orderPending = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        return view('user.dashboard', compact('orderProses', 'produkDibeli', 'orderPending'));
    }
}
}