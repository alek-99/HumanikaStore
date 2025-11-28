<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        
        $products = Product::with(['ratings.user'])->get();
        return view('user.produk.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::with(['ratings.user'])->findOrFail($id);
        return view('user.produk.show', compact('product'));
    }
}
