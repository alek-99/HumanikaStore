<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        
        $products = Product::all();
        return view('user.produk.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('user.produk.show', compact('product'));
    }
}
