<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderanUserController extends Controller
{
     public function index(Request $request)
    {
        // filter status jika ada
        $status = $request->status;

        $orders = Order::with('user', 'product')
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            // total orderan
            $totalOrder = Order::count();
            // total penjualan
            $totalPenjualan = Order::join('products', 'orders.product_id', '=', 'products.id')
    ->where('orders.status', 'confirmed')
    ->sum(DB::raw('products.harga * orders.quantity'));
            // Rekap status
            $statusCount = [
            'pending'   => Order::where('status', 'pending')->count(),
            'process'   => Order::where('status', 'process')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'canceled'  => Order::where('status', 'canceled')->count(),
        ];
        // Rekap bulanan (untuk grafik)
        $rekapBulanan = Order::join('products', 'orders.product_id', '=', 'products.id')
    ->selectRaw("MONTH(orders.created_at) as bulan, SUM(products.harga * orders.quantity) as total")
    ->where('orders.status', 'confirmed')
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();


        return view('admin.orders.index', compact('orders', 'status', 'totalOrder', 'totalPenjualan', 'statusCount', 'rekapBulanan'));
    }
    public function show($id)
    {
        $order = Order::with('user', 'product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,process,confirmed,canceled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui');
    }

    /**
     * Hapus order (opsional)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order berhasil dihapus');
    }
    
}
