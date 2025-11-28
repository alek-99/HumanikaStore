<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
   public function create($orderId)
    {
        $order = Order::with('product')->findOrFail($orderId);

        // Hanya izinkan review jika order selesai
        if ($order->status !== 'completed') {
            abort(403, 'Order belum selesai');
        }

        return view('review.create', compact('order'));
    }

  
}