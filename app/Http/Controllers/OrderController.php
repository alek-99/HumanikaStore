<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Helpers\Fonte;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Validasi input user
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'alamat_pengiriman' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'payment_method' => 'required|in:e-wallet,cash_on_delivery',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Hitung total harga
        $totalHarga = $product->harga * $validated['quantity'];

        // Upload bukti pembayaran
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        // Simpan order
        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'alamat_pengiriman' => $validated['alamat_pengiriman'],
            'no_hp' => $validated['no_hp'],
            'payment_method' => $validated['payment_method'],
            'bukti_pembayaran' => $buktiPath,
        ]);

        
    // =============================
    // ✨ KIRIM NOTIF WA KE ADMIN
    // =============================
    $message =
        "📢 *Order Baru Masuk!*\n\n".
        "🛒 Produk: *{$product->name}*\n".
        "🔢 Qty: {$validated['quantity']}\n".
        "💵 Total: Rp " . number_format($product->harga * $validated['quantity'], 0, ',', '.') . "\n".
        "📍 Alamat: {$validated['alamat_pengiriman']}\n".
        "📱 No HP Customer: {$validated['no_hp']}\n".
        "💳 Pembayaran: {$validated['payment_method']}\n\n".
        "Silakan cek dashboard admin.";

    // Fonte::send(env('ADMIN_WA'), $message);
    // =============================
Fonte::send(env('ADMIN_WA'), $message);


        return redirect()->back()->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
    }

    public function myOrder()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders'));
    }
    public function cancel($id)
{
    $order = Order::where('id', $id)
                  ->where('user_id', Auth::id()) // keamanan: hanya pemilik order yg boleh cancel
                  ->firstOrFail();

    // Hanya boleh cancel jika masih pending atau process
    if (!in_array($order->status, ['pending', 'process'])) {
        return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    $order->status = 'canceled';
    $order->save();

    return back()->with('success', 'Pesanan berhasil dibatalkan.');
}

}