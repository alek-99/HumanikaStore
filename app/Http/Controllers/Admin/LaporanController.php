<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrderBulananExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari request
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Laporan bulanan
        $laporan = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.harga', 'products.name')
            ->whereMonth('orders.created_at', $bulan)
            ->whereYear('orders.created_at', $tahun)
            ->get();

        // Total penjualan
        $totalPenjualan = $laporan->sum('harga');

        // Total order
        $totalOrder = $laporan->count();

        return view('admin.laporan.index', compact(
            'laporan',
            'bulan',
            'tahun',
            'totalOrder',
            'totalPenjualan'
        ));
    }

    // EXPORT EXCEL (nanti dibuatkan)
    public function exportExcel(Request $request)
    {
       $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $namaFile = "Laporan-Order-Bulanan-{$bulan}-{$tahun}.xlsx";

    return Excel::download(new OrderBulananExport($bulan, $tahun), $namaFile);
    }
}
