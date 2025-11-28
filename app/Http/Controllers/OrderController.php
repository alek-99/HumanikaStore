<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Pest\Support\Str;
use App\Helpers\Fonte;
use App\Models\Rating;
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
    // $message =
    //     "📢 *Order Baru Masuk!*\n\n".
    //     "🛒 Produk: *{$product->name}*\n".
    //     "🔢 Qty: {$validated['quantity']}\n".
    //     "💵 Total: Rp " . number_format($product->harga * $validated['quantity'], 0, ',', '.') . "\n".
    //     "📍 Alamat: {$validated['alamat_pengiriman']}\n".
    //     "📱 No HP Customer: {$validated['no_hp']}\n".
    //     "💳 Pembayaran: {$validated['payment_method']}\n\n".
    //     "Silakan cek dashboard admin.";

    // Fonte::send(env('ADMIN_WA'), $message);
    // =============================
// Fonte::send(env('ADMIN_WA'), $message);
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
// konfirmasi orderan
public function confirm($id)
{
     $order = Order::where('id', $id)
                  ->where('user_id', Auth::id()) // keamanan: hanya pemilik order yg boleh cancel
                  ->firstOrFail();

    // Cek apakah pesanan boleh dikonfirmasi
    if ($order->status !== 'pending') {
        return back()->with('error', 'Pesanan tidak dapat dikonfirmasi.');
    }

    $order->status = 'confirmed';
    $order->save();

    return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
}


 public function reviewCreate($orderId)
    {
        $order = Order::with('product')->findOrFail($orderId);

        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya izinkan review jika order confirmed (selesai)
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Pesanan harus dikonfirmasi terlebih dahulu sebelum memberikan ulasan.');
        }

        // Cek apakah sudah pernah review
        $existingRating = Rating::where('order_id', $order->id)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingRating) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        return view('user.reviews.create', compact('order'));
    }

    public function reviewStore(Request $request, $orderId)
    {
        $order = Order::with('product')->findOrFail($orderId);

        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Validasi status order
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Pesanan harus dikonfirmasi terlebih dahulu.');
        }

        // Cek apakah sudah pernah review
        $existingRating = Rating::where('order_id', $order->id)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingRating) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        Rating::create([
            'user_id'    => Auth::id(),
            'product_id' => $order->product_id,
            'order_id'   => $order->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()->route('user.orders.index')->with('success', 'Terima kasih atas ulasannya!');
    }
    public function getReviews($id)
{
    $product = Product::findOrFail($id);

    $reviews = $product->ratings()->with('user')->get()->map(function ($r) {
        return [
            'user' => $r->user->name ?? 'User',
            'rating' => (int)$r->rating,
            'comment' => $r->comment,
            'date' => $r->created_at->diffForHumans(),
        ];
    });

    return response()->json($reviews);
}
public function getProof(Order $order)
{
    if ($order->user_id !== Auth::id()) {
        abort(403);
    }

    $url = asset('storage/' . $order->bukti_pembayaran);
    $type = Str::endsWith($order->bukti_pembayaran, '.pdf') ? 'pdf' : 'image';

    return response()->json([
        'url' => $url,
        'type' => $type
    ]);
}
}